<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../registry.php';
//Open a database connection
$db = DBOpen();

if(isset($_POST['System'])) {
    $system = filter_input(INPUT_POST, 'System');
} else {
    $system = null;
}

if(isset($_POST['Planet'])) {
    $planet = filter_input(INPUT_POST, 'Planet');
} else {
    $planet = null;
}

if(isset($_POST['Moon'])) {
    $moon = filter_input(INPUT_POST, 'Moon');
} else {
    $moon = null;
}

if(isset($_POST['EndDate'])) {
    $endDate = filter_input(INPUT_POST, 'EndDate');
    $endDate = strtotime($endDate . "00:00:00");
} else {
    $endDate = null;
}

//Print the HTML Header
PrintHTMLHeader();

if($system == null || $planet == null || $moon == null || $endDate == null) {
    printf("<div class=\"container\">");
    printf("<div class=\'jumbotron\">");
    printf("<h2>Please try again!</h2>");
    printf("</div>");
    printf("</div>");
}
//Update the database then print successfull message.
$success = $db->update('Moons', array('System' => $system, 'Planet' => $planet, 'Moon' => $moon), array(
    'EndDate' => $endDate
));

printf("<div class=\"container\">");
printf("<div class=\"jumbotron\">");
printf("<h3>Update Success!</h3>");
printf("</div>");
printf("</div>");