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
$names = $db->fetchColumn('SELECT Name FROM ItemComposition');

PrintHTMLHeader();
printf("<body>");

printf("<form action=\"functions/process/price.php\" method=\"POST\">");
printf("<div class=\"form-group\">");
printf("<label for=\"firstOre\">First Ore</label>");
printf("<select class=\"custom-select\" id=\"firstOre\" name=\"firstOre\">");
printf("<option selected>Choose Ore</option");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("<option value=\"None\">None</option>");
printf("</select>");
printf("<input class=\"form-control\" id=\"firstOre\" name=\"firstOre\" default=\"None\">");
printf("<input class=\"form-control\" id=\"firstQuan\" name=\"firstQuan\" default=\"0.00\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"secondOre\">Second Ore</label>");
printf("<select class=\"custom-select\" id=\"secondOre\" name=\"secondOre\">");
printf("<option selected>Choose Ore</option");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("<option value=\"None\">None</option>");
printf("</select>");
printf("<input class=\"form-control\" id=\"secondQuan\" name=\"secondQuan\" default=\"0.00\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"thirdOre\">Third Ore</label>");
printf("<select class=\"custom-select\" id=\"thirdOre\" name=\"thirdOre\">");
printf("<option selected>Choose Ore</option");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("<option value=\"None\">None</option>");
printf("</select>");
printf("<input class=\"form-control\" id=\"thirdQuan\" name=\"thirdQuan\" default=\"0.00\">");
printf("</div>");
printf("<div class=\"form-group\">");
printf("<label for=\"fourthOre\">Fourth Ore</label>");
printf("<select class=\"custom-select\" id=\"fourthOre\" name=\"fourthOre\">");
printf("<option selected>Choose Ore</option");
foreach($names as $name) {
    printf("<option value=\"" . $name . "\">" . $name . "</option>");
}
printf("<option value=\"None\">None</option>");
printf("</select>");
printf("<input class=\"form-control\" id=\"fourthQuan\" name=\"fourthQuan\" default=\"0.00\">");
printf("</div>");
printf("<button type=\"submit\" class=\"btn btn-primary mb-s\">Click for Price</button>");
printf("</form>");

printf("</body>");
printf("</html>");