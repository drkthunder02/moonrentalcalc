<?php

/* 
 *  W4RP Services
 *  GNU Public License
 */

namespace W4RP;

class ESI {
    protected $refreshToken;
    protected $refreshTokenExpiry;
    protected $accessToken;
    
    protected $clientId;
    protected $secretKey;
    protected $userAgent;
    
    protected $errorCount;
    protected $blocked;
    
    protected $error = array(
        'Authorzation' => 'Authorization not provided'
    );
    
    protected $esi = array(
        'scheme' => 'https',
        'host' => 'esi.tech.ccp.is',
        'path' => 'latest'
    );
    
    public function __construct($accessToken, $refreshToken, $refreshTokenExpiry, $client = null, $secret = null, $useragent = null) {
        if($client == null || $secret == null || $useragent == null) {
            //Parse the data for the ESI Configuration file
            $fileEsi = parse_ini_file(__DIR__.'/../configuration/esi.ini');
            $this->clientId = $fileEsi['client_id'];
            $this->secretKey = $fileEsi['secret'];
            $this->userAgent = $fileEsi['userAgent'];
        } else {
            $this->clientId = $client;
            $this->secretKey = $secret;
            $this->userAgent = $useragent; 
        }
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->refreshTokenExpiry = $refreshTokenExpiry;
        
        $this->errorCount = 0;
        $this->blocked = false;
        
        //Make sure the access token hasn't expired
        if(time() > $this->GetRefreskTokenExpiry()) {
            $this->RefreshAccess();
        }
    }
    
    public function SetAccessToken($access) {
        $this->accessToken = $access;
    }
    
    public function SetRefreshtoken($refresh) {
        $this->refreshToken = $refresh;
    }
    
    public function SetRefreshTokenExpiry($expire) {
        $this->refreshTokenExpiry = $expire;
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
    
    public function CheckRefreshExpired() {
        if(time() > $this->refreshTokenExpiry) {
            return true;
        } else {
            return false;
        }
    }
    
    public function IncreaseErrorCount() {
        $this->errorCount++;
    }
    
    public function SetErrorCount($count) {
        $this->errorCount = $count;
    }
    
    public function DecreaseErrorCount() {
        $this->errorCount--;
    }
    
    protected function CheckErrorCount() {
        if($this->errorCount > 60) {
            $this->blocked = true;
        }
    }
    
    public function RefreshAccess($useragent = null) {
        if($useragent == null) {
            $useragent = $this->userAgent;
        }
        
        $url = 'https://login.eveonline.com/oauth/token';
        $header = 'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->secretKey);
        //Convert the passed array into a field string for the post fields
        $fields = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken
        );
        $fields_string = $this->ConvertFields($fields);
     
        //Initialize the cURL connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        //Get the resultant data from the curl call in an array format
        $data = json_decode($result, true);
        //Modify the variables of the class
        $this->refreshToken = $data['refresh_token'];
        $this->refreshTokenExpiry = time() + $data['expires_in'];
        $this->accessToken = $data['access_token'];        
    }

    protected function ConvertFields($fields) {
        $fields_string = '';
        foreach($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        
        return $fields_string;
    }
    
    protected function BuildSingleUrl($type, $id) {
        $firstPart = 'https://esi.tech.ccp.is/latest/';
        $lastPart = '/?datasource=tranquility';
        
        if($type == 'Character') {
            $url = $firstPart . 'characters/' . $id . $lastPart;
        } else if ($type == 'Corporation') {
            $url = $firstPart . 'corporations/' . $id . $lastPart;
        } else if ($type == 'Alliance') {
            $url = $firstPart . 'alliances/' . $id . $lastPart;
        }
        
        return $url;
    }
    
    protected function BuildMultiUrl($type, $data) {
        $firstPart = 'https://esi.tech.ccp.is/latest/';
        $lastPart = '/?datasource=tranquility';
        
        $urls = array();
        
        if($type == 'Character') {
            foreach($data as $key => $value) {
                $urls[$key] = $firstPart . 'characters/' . $value . $lastPart;
            }
        } else if ($type == 'Corporation') {
            foreach($data as $key => $value) {
                $urls[$key] = $firstPart . 'corporations/' . $value . $lastPart;
            }
        } else if ($type == 'Alliance') {
            foreach($data as $key => $value) {
                $urls[$key] = $firstPart . 'alliances/' . $value . $lastPart;
            }
        }
        
        return $urls;
    }
    
    protected function GetESIInfo($id, $type, $useragent = null) {
        if($useragent == null) {
            $useragent = $this->userAgent;
        }
        $url = $this->BuildSingleUrl($type, $id);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        //Check for a curl error
        if(curl_error($ch)) {
            return null;
        } else {
            curl_close($ch);
            $data = json_decode($result, true);
            return $data;
        }
    }
    
    protected function GetPublicESIData($url, $useragent) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        
        if(isset($data['error'])) {
            $this->errorCount++;
            return null;
        }
        
        return $data;
    }
    
    protected function GetESIData($url, $useragent, $header) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', $header));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        
        if(isset($data['error'])) {
            $this->errorCount++;
            return null;
        }
        
        return $data;
    }
    
    public function GetESIHeaderData($url, $useragent, $header) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Application: application/json', $header));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $output = curl_exec($ch);
        curl_close($ch);
        
        $headers = array();
        $data = explode("\n", $output);
        $headers['status'] = $data[0];
        array_shift($data);
        foreach($data as $part) {
            $middle = explode(":", $part);
            if(sizeof($headers) >= 2) {
                $headers[trim($middle[0])] = trim($middle[1]);
            }            
        }
        
        return $headers;
        
        /*
        $headers = array();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Application: application/json', $header));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($ch, $header) use (&$headers)
            {
              $len = strlen($header);
              $header = explode(':', $header, 2);
              if (count($header) < 2) // ignore invalid headers
                return $len;

              $name = strtolower(trim($header[0]));
              if (!array_key_exists($name, $headers)){
                  $headers[$name] = [trim($header[1])];
              }
              else {
                  $headers[$name][] = trim($header[1]);
              }
                

              return $len;
            }
          );
        $result = curl_exec($ch);
        */
    }

    protected function ProcessError($error) {
        
    }
    
    protected function PostESIData($url, $useragent, $header, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POST, count($post));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        
        return $data;
    }
    
    protected function DecodeESIDate($date) {
        //Find the end of the date
        $dateEnd = strpos($date, "T");
        //Split the string up into date and time
        $dateArr = str_split($date, $dateEnd);
        //Trim the T and Z from the end of the second item in the array
        $dateArr[1] = ltrim($dateArr[1], "T");
        $dateArr[1] = rtrim($dateArr[1], "Z");
        //Return the date and time back to calling function
        return $dateArr;
    }
    
    protected function GetMultiESIData($data = array(), $options = array(), $useragent = null) {
        //data must be of type array
        //options must be of type array
        //useragent can be defined in call or in function
        if($useragent == null) {
            $useragent = $this->userAgent;
        }
        
        //Array of cURL handles
        $curls = array();

        //Data to be returned
        $result = array();
        $results = array();

        //Multi cURL handle
        $mh = curl_multi_init();

        //Loop through the $data and create curl handles
        //then add them to the mutli-handle for curl
        foreach($data as $key => $value) {
            $curls[$key] = curl_init();
            $url = $value;
            curl_setopt($curls[$key], CURLOPT_URL, $url);
            curl_setopt($curls[$key], CURLOPT_USERAGENT, $useragent);
            curl_setopt($curls[$key], CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($curls[$key], CURLOPT_HTTPGET, true);
            curl_setopt($curls[$key], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curls[$key], CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curls[$key], CURLOPT_SSL_VERIFYHOST, 2);

            //Extra Options
            if(!empty($options)) {
                curl_setopt_array($curls[$key], $options);
            }

            //Add the handles
            curl_multi_add_handle($mh, $curls[$key]);
        }

        //Execute the cURL handles
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);

        //Get the content and remove the handles
        foreach($curls as $key => $value) {
            $result[$key] = curl_multi_getcontent($value);
            curl_multi_remove_handle($mh, $value);
        }

        //Decode each result in its own array of arrays
        foreach($result as $info => $mined) {
            $results[$info] = json_decode($mined, true);
            curl_multi_remove_handle($mh, $mined);
        }

        //Once all the calls are completed close the multi curl channel
        curl_multi_close($mh);

        return $results;
    }
}