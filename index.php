<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/functions/registry.php';

$db = DBOpen();

//Get all the types of ore
$names = $db->fetchColumnMany('SELECT Name FROM ItemComposition ORDER BY Name ASC');

PrintHTMLHeader();
//Print the HTML Body tag
printf("<body>");

//Print page title
printf("<div class=\"page-header text-white\" align=\"center\">");
printf("<h2>Warped Intentions Moon Rental Calculator</h2>");
printf("</div>");
//Print the container for the form
printf("<div class=\"container col-md-3 col-md-offset-3\">");
printf("<form class=\"text-center\" action=\"functions/process/price.php\" method=\"POST\">");
printf("<div class=\"form-group\">");
printf("<label class=\"text-white\" for=\"firstOre\">First Ore</label>");
printf("<select class=\"custom-select\" id=\"firstOre\" name=\"firstOre\">");
printf("<option value=\"None\" selected>None</option>");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("</select>");
printf("<input class=\"form-control\" id=\"firstQuan\" name=\"firstQuan\" default=\"None\">");
printf("</div>");
//Second Ore
printf("<div class=\"form-group\">");
printf("<label class=\"text-white\" for=\"secondOre\">Second Ore</label>");
printf("<select class=\"custom-select\" id=\"secondOre\" name=\"secondOre\">");
printf("<option value=\"None\" selected>None</option>");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("</select>");
printf("<input class=\"form-control\" id=\"secondQuan\" name=\"secondQuan\" default=\"0.00\">");
printf("</div>");
//Third Ore
printf("<div class=\"form-group\">");
printf("<label class=\"text-white\" for=\"thirdOre\">Third Ore</label>");
printf("<select class=\"custom-select\" id=\"thirdOre\" name=\"thirdOre\">");
printf("<option value=\"None\" selected>None</option>");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("</select>");
printf("<input class=\"form-control\" id=\"thirdQuan\" name=\"thirdQuan\" default=\"0.00\">");
printf("</div>");
//Fourth Ore
printf("<div class=\"form-group\">");
printf("<label class=\"text-white\" for=\"fourthOre\">Fourth Ore</label>");
printf("<select class=\"custom-select\" id=\"fourthOre\" name=\"fourthOre\">");
printf("<option value=\"None\" selected>None</option>");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("</select>");
printf("<input class=\"form-control\" id=\"fourthQuan\" name=\"fourthQuan\" default=\"0.00\">");
printf("</div>");
printf("<button type=\"submit\" class=\"btn btn-primary mb-s\">Click for Price</button>");
printf("</form>");
printf("</div>");

printf("</body>");
printf("</html>");