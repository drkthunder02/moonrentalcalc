<?php

/* 
 *  W4RP Services
 *  GNU Public License
 */

//PHP Debug Mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Get the required files from the function registry
require_once __DIR__.'/functions/registry.php';

//Start the session
$session = new W4RP\session();

//Start the ESI class for logging in
$esiLogin = new W4RP\Login();
//Open a database connection
$db = DBOpen();

//If the state is not set then set it to NULL
if(!isset($_SESSION['state'])) {
    $_SESSION['state'] = uniqid();
}

PrintHTMLHeader();

$state = $esiLogin->ESIStateMachine($_REQUEST['action']);

if($state == 'logged' && $esiLogin->GetCorporationName() == 'Spatial Forces') {
    $_SESSION['CharacterName'] = $esiLogin->GetCharacterName();
    $_SESSION['CorporationName'] = $esiLogin->GetCorporationName();
    $_SESSION['AllianceName'] = $esiLogin->GetAllianceName();
    $_SESSION['LoginState'] = true;
    
    $location = 'http://' . $_SERVER['HTTP_HOST'];
    $location = $location . '/secure/index.php';
    header("Location: $location");
    die();
} else {
    unset($_SESSION['state']);
    $_SESSION['LoginState'] = false;
    printf("<dv class=\"jumbotron\">");
    printf("<div class=\"container\">");
    printf("Sorry but you are not allowed to login here.");
    printf("</div>");
    printf("</div>");
}

//These are to close out the PrintHTMLHeader() call
printf("</body>");
printf("</html>");

//Close our database connection
DBClose($db);

?>
