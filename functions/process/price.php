<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
//Always assume a 1 month pull which equates to 5.55m3 per second or 2,592,000 seconds
//Total pull size is 14,385,600 m3
$totalPull = 14385600.00;
//Get the configuration for pricing calculations
$config = $db->fetchRow('SELECT * FROM Config');

if($firstOre != "None") {
    $firstComp = $db->fetchRow('SELECT * FROM Composition WHERE Name= :name', array('name' => $firstOre));
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
    $secondComp = $db->fetchRow('SELECT * FROM Composition WHERE Name= :name', array('name' => $secondOre));
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
//Calculate the rental price
$rentalPrice = $totalPriceMined * $config['RentalTax'] * $config['RefineRate'];


//HTML Portion of the page
PrintHTMLHeader();
printf("<body>");
printf("<div class=\"jumbotron\">");
printf("Rental Price: " . $rentalPrice . " ISK<br>");
printf("Total Moon Value: " . $totalPriceMined . " ISK<br>");
printf("</div>");
printf("</body>");