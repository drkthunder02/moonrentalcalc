<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../functions/registry.php';

//Create a session
$session = new W4RP\session();

PrintHTMLHeader();

//Check session to make sure we are logged in
if($_SESSION['LoginState'] == false) {
    printf("<div class=\"container\">");
    printf("<div class=\"jumbotron\">");
    printf("<h1>You are not allowed to access this area.</h1>");
    printf("</div>");
    printf("</div>");
    die();
}

PrintNavBar();
print("<div class=\"container\"><div class=\"jumbotron\">");
//Create form for updating a moon end date
printf("<form action=\"../functions/process/updatemoon.php\" method=\"POST\">");
printf("<div class=\"form-group\">");
printf("<label for=\"moonSelector\">Enter System</label>");
printf("<input type=\"text\" name=\"System\" class=\"form-content\" id=\"System\" placeholder=\"System\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"moonSelector\">Enter Planet</label>");
printf("<input type=\"text\" name=\"Planet\" class=\"form-content\" id=\"Planet\" placeholder=\"Planet\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"moonSelector\">Enter Moon</label>");
printf("<input type=\"text\" name=\"Moon\" class=\"form-content\" id=\"Moon\" placeholder=\"Moon\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"Corp\">Corporation Renting</label>");
printf("<input type=\'text\" name=\"Corp\" class=\"form-content\" id=\"Corp\" placeholder=\"SP3C\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"RentalEnd\">Enter End Date</label>");
printf("<input type=\"text\" name=\"RentalEnd\" class=\"form-content\" id=\"RentalEnd\" placeholder=\"End Date (d-m-Y)\">");
printf("</div>");
printf("<button type=\"submit\" class=\"btn btn-outline-warning\">Submit</button>");
printf("</form>");
printf("</div></div>");
