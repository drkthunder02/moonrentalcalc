<?php

/* 
 *  W4RP Services
 *  GNU Public License
 */

namespace W4RP;

class Login extends \W4RP\ESI {
    
    private $characterId;
    private $characterName;
    private $tokenType;
    
    private $corporationId;
    private $corporationName;
    
    private $allianceId;
    private $allianceName;
    
    private $logged;
    
    protected $refreshToken;
    protected $refreshTokenExpiry;
    protected $accessToken;
    
    protected $clientId;
    protected $secretKey;
    protected $useragent;
    protected $scope;
    
    public function __construct() {
        //Parse the data for the ESI Configuration file
        $fileEsi = parse_ini_file(__DIR__.'/../configuration/esi.ini');
        $this->clientId = $fileEsi['client_id'];
        $this->secretKey = $fileEsi['secret'];
        $this->useragent = $fileEsi['useragent'];
        $this->scope = $fileEsi['scope'];
        
        //Start a session if one hasn't been started
        if (session_status() == PHP_SESSION_NONE) {
            $session = new \W4RP\session();
        }
        
    }
    
    public function GetCharacterId() {
        return $this->characterId;
    }
    
    public function GetCharacterName() {
        return $this->characterName;
    }
    
    public function GetCorporationId() {
        return $this->corporationId;
    }
    
    public function GetCorporationName() {
        return $this->corporationName;
    }
    
    public function GetAllianceId() {
        return $this->allianceId;
    }
    
    public function GetAllianceName() {
        return $this->allianceName;
    }
    
    public function GetAccessToken() {
        return $this->accessToken;
    }
    
    public function GetRefreshToken() {
        return $this->refreshToken;
    }
    
    public function GetRefreskTokenExpiry() {
        return $this->refreshTokenExpiry;
    }
    
    public function ESIStateMachine($state) {
        
        switch($state) {
            case 'new':
                $this->DisplayLoginButton();
                die();
                break;
            case 'eveonlinecallback':
                $this->VerifyCallback();
                return 'logged';
                break;
            default:
                $this->UnknownState();
                break;
        }
    }
    
    private function VerifyCallback() {
        if($this->CheckState() == 'okay') {
            $this->RetrieveAccessToken();
            $this->RetrieveCharacterId();
            
            //Get all the information we might need, and store it
            $char = $this->GetESIInfo($this->characterId, 'Character', $this->useragent);
            $this->characterName = $char['name'];
            
            $corp = $this->GetESIInfo($char['corporation_id'], 'Corporation', $this->useragent);
            $this->corporationId = $char['corporation_id'];
            $this->corporationName = $corp['corporation_name'];
            
            if(isset($corp['alliance_id'])) {
                $ally = $this->GetESIInfo($corp['alliance_id'], 'Alliance', $this->useragent);
                $this->allianceId = $corp['alliance_id'];
                $this->allianceName = $ally['alliance_name'];
            }
        }  
        
        if($this->characterId != null) {
            $this->logged = true;
        } else {
            $this->logged = false;
        }
    }
    
    private function DisplayLoginButton() {
        $html = "";
        $html .= "<div class=\"container\">";
        $html .= "<br><br><br>";
        $html .= "<div class=\"jumbotron\">";
        $html .= "<h1><p align=\"center\">Warped Intentions Services Login</p></h1>";
        $html .= "<br>";
        $html .= "<p align=\"center\">One stop shop for the alliance services.</p>";
        $html .= "<br>";
        $html .= "<p align=\"center\">";
        $html .= "<a href=\"https://login.eveonline.com/oauth/authorize/?response_type=code&redirect_uri=";
        $html .= urldecode($this->GetSSOCallbackURL());
        $html .= "&client_id=" . $this->clientId;
        $html .= "&scope=" . urlencode($this->scope);
        $html .= "&state=";
        $html .= $_SESSION['state'] . "\">";
        $html .= "<img src=\"images/EVE_SSO_Login_Buttons_Large_Black.png\">";
        $html .= "</a>";
        $html .= "</p>";
        $html .= "</div>";
        $html .= "</div>";
        $this->PrintHTML($html);
    }
    
    private function GetSSOCallbackURL() {
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?action=eveonlinecallback';
    }
    
    private function UnknownState() {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?action=new');
        die();
    }
    
    private function PrintHTML($html) {
        printf($html);
    }
    
    private function CheckState() {
        $html = "";
        
        if($_REQUEST['state'] != $_SESSION['state']) {
            $html .= "<div class=\"container\">";
            $html .= "Invalid State!  You will have to start again.";
            $html .= "<a href=\"" . $_SERVER['PHP_SELF'] . "?action=new\">Start again!</a>";
            $html .= "</div>";
            $this->PrintHTML($html);
            $this->UnsetState();
            die();
        } else {
            return 'okay';
        }
    }
    
    private function UnsetState() {
        unset($_SESSION['state']);
    }
    
    private function RetrieveCharacterId() {
        $url = 'https://login.eveonline.com/oauth/verify';
        $header = 'Authorization: Bearer ' . $this->accessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        
        $this->characterId =  $data['CharacterID'];
        $this->characterName = $data['CharacterName'];
        $this->tokenType = $data['TokenType'];
    }
    
    private function RetrieveAccessToken() {
        unset($_SESSION['state']);
        $url = 'https://login.eveonline.com/oauth/token';
        $header = 'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->secretKey);
        $fields_string='';
        $fields = array(
            'grant_type' => 'authorization_code',
            'code' => $_GET['code']
        );
        foreach($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        //Initialize the curl channel
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        curl_close($ch);            
        $data = json_decode($result, true);
        $this->accessToken = $data['access_token'];
        $this->refreshToken = $data['refresh_token'];
        $this->refreshTokenExpiry = time() + $data['expires_in'];
    }
}