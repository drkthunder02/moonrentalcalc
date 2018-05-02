<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../registry.php';
//Open a database connection
$db = DBOpen();

//Get the form data
$firstOre = filter_input(INPUT_POST, 'firstOre');
$firstPerc = filter_input(INPUT_POST, 'firstQuan');
$secondOre = filter_input(INPUT_POST, 'secondOre');
$secondPerc = filter_input(INPUT_POST, 'secondQuan');
$thirdOre = filter_input(INPUT_POST, 'thirdOre');
$thirdPerc = filter_input(INPUT_POST, 'thirdQuan');
$fourthOre = filter_input(INPUT_POST, 'fourthOre');
$fourthPerc = filter_input(INPUT_POST, 'fourthQuan');

//Divide by 100 if a whole number was entered instead of a decimal
if($firstPerc >= 1.00) {
    $firstPerc = $firstPerc / 100.00;
}
if($secondPerc >= 1.00) {
    $secondPerc = $secondPerc / 100.00;
}
if($thirdPerc >= 1.00) {
    $thirdPerc = $thirdPerc / 100.00;
}
if($fourthPerc >= 1.00) {
    $fourthPerc = $fourthPerc / 100.00;
} 

//Always assume a 1 month pull which equates to 5.55m3 per second or 2,592,000 seconds
//Total pull size is 14,385,600 m3
$totalPull = 5.55 * (3600.00 * 24.00 * 30.00);
//Get the configuration for pricing calculations
$config = $db->fetchRow('SELECT * FROM Config');

if($firstOre != "None") {
    $firstComp = $db->fetchRow('SELECT * FROM ItemComposition WHERE Name= :name', array('name' => $firstOre));
    //Find the m3 value of the first ore
    $firstActualm3 = floor($firstPerc * $totalPull);
    //Calculate the units of the first ore
    $firstUnits = floor($firstActualm3 / $firstComp['m3Size']);
    //Get the unit price from the database
    $firstUnitPrice = $db->fetchColumn('SELECT UnitPrice  FROM OrePrices WHERE Name= :name', array('name'=> $firstOre));
    //Calculate the total price for the first ore
    $firstTotal = $firstUnits * $firstUnitPrice;
} else {
    $firstTotal = 0.00;
}

if($secondOre != "None") {
    $secondComp = $db->fetchRow('SELECT * FROM ItemComposition WHERE Name= :name', array('name' => $secondOre));
    //find the m3 value of the second ore
    $secondActualm3 = floor($secondPerc * $totalPull);
    //Calculate the units of the second ore
    $secondUnits = floor($secondActualm3 / $secondComp['m3Size']);
    //Get the  unit price from the database
    $secondUnitPrice = $db->fetchColumn('SELECT UnitPrice FROM OrePrices WHERE Name= :name', array('name' => $secondOre));
    //calculate the total price for the second ore
    $secondTotal = $secondUnits * $secondUnitPrice;
} else {
    $secondTotal = 0.00;
}

if($thirdOre != "None") {
    $thirdComp = $db->fetchRow('SELECT * FROM ItemComposition WHERE Name= :name', array('name' => $thirdOre));
    //find the m3 value of the third ore
    $thirdActualm3 = floor($thirdPerc * $totalPull);
    //calculate the units of the third ore
    $thirdUnits = floor($thirdActualm3 / $thirdComp['m3Size']);
    //Get the unit price from the database
    $thirdUnitPrice = $db->fetchColumn('SELECT UnitPrice FROM OrePrices WHERE Name= :name', array('name' => $thirdOre));
    //calculate the total price for the third ore
    $thirdTotal = $thirdUnits * $thirdUnitPrice;
} else {
    $thirdTotal = 0.00;
}

if($fourthOre != "None") {
    $fourthComp = $db->fetchRow('SELECT * FROM ItemComposition WHERE Name= :name', array('name' => $fourthOre));
    //Find the m3 value of the fourth ore
    $fourthActualm3 = floor($fourthPerc * $totalPull);
    //Calculate the units of the fourth ore
    $fourthUnits = floor($fourthActualm3 / $fourthComp['m3Size']);
    //Get the unit price from the database
    $fourthUnitPrice = $db->fetchColumn('SELECT UnitPrice FROM OrePrices WHERE Name= :name', array('name' => $fourthOre));
    //calculate the total price for the fourth ore
    $fourthTotal = $fourthUnits * $fourthUnitPrice;
} else {
    $fourthTotal = 0.00;
}

//Calculate the total to price to be mined in one month
$totalPriceMined = $firstTotal + $secondTotal + $thirdTotal + $fourthTotal;
//Calculate the rental price.  Refined rate is already included in the price from rental composition
$rentalPrice = $totalPriceMined * ($config['RentalTax'] / 100.00);

//Format the rental price to the appropriate number
$rentalPrice = number_format($rentalPrice, "2", ".", ",");
$totalPriceMined = number_format($totalPriceMined, "2", ".", ",");

//HTML Portion of the page
PrintHTMLHeader();
printf("<body>");
printf("<div class=\"container col-md-6 col-md-offset-3\">");
printf("<div class=\"jumbotron col-md-6\">");
printf("Rental Price: " . $rentalPrice . " ISK<br>");
printf("Total Moon Value: " . $totalPriceMined . " ISK<br>");
printf("</div>");
printf("</div>");
printf("</body>");