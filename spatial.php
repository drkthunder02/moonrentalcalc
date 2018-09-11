<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/functions/registry.php';
//Open a connection to the database
$db = DBOpen();
//Gather all the moons from the database we want to rent out
$moons = $db->fetchRowMany('SELECT * FROM Moons ORDER BY System, Planet, Moon ASC');

//Print the HTML Header
PrintHTMLHeader();
//Print the Navigation Bar
PrintNavBar();
//Create the container for the table to fit in
printf("<div class=\"container col-md-12\">");

//Create the primary table
printf("<table class=\"table table-dark\">");
printf("<thead>");
printf("<tr>");
printf("<th scope=\"col\">System</th>");
printf("<th scope=\"col\">Planet</th>");
printf("<th scope=\"col\">Moon</th>");
printf("<th scope=\"col\">Name</th>");
printf("<th scope=\"col\">First Ore</th>");
printf("<th scope=\"col\">Second Ore</th>");
printf("<th scope=\"col\">Third Ore</th>");
printf("<th scope=\"col\">Fourth Ore</th>");
printf("<th scope=\"col\">Price / Month </th>");
printf("<th scope=\"col\">Corp Renting</th>");
printf("<th scope=\"col\">Rental End</th>");
printf("</tr>");
printf("</thead>");
printf("<tbody>");
//For each moon populate the table
foreach($moons as $moon) {
    //Calculate the price of the moon
    $price = SpatialMoons($moon['FirstOre'], $moon['FirstQuantity'], $moon['SecondOre'], $moon['SecondQuantity'], $moon['ThirdOre'], $moon['ThirdQuantity'], $moon['FourthOre'], $moon['FourthQuantity'], $db);
    //Calculate the time in from UTC to human readable time
    $endTime = date("d/m/Y", $moon['RentalEnd']);

    printf("<tr>");
    printf("<td>" . $moon['System'] . "</td>");
    printf("<td>" . $moon['Planet'] . "</td>");
    printf("<td>" . $moon['Moon'] . "</td>");
    printf("<td>" . $moon['StructureName'] . "</td>");
    printf("<td>" . $moon['FirstOre'] . ": " . $moon['FirstQuantity'] . "</td>");
    printf("<td>" . $moon['SecondOre'] . ": " . $moon['SecondQuantity'] . "</td>");
    printf("<td>" . $moon['ThirdOre'] . ": " . $moon['ThirdQuantity'] . "</td>");
    printf("<td>" . $moon['FourthOre'] . ": " . $moon['FourthQuantity'] . "</td>");
    printf("<td>" . $price . "</td>");
    if($moon['RentalCorp'] == null) {
	printf("<td>Not Rented</td>");
    } else {
	printf("<td>" . $moon['RentalCorp'] . "</td>");
    }
    printf("<td>" . $endTime . "</td>");
    printf("</tr>");
}
printf("</tbody>");
printf("</table>");
//End the container
printf("</div>");
