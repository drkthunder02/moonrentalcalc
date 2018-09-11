<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function SpatialMoons($firstOre, $firstQuan, $secondOre, $secondQuan, $thirdOre, $thirdQuan, $fourthOre, $fourthQuan, \Simplon\Mysql\Mysql $db){
    //Always assume a 1 month pull which equates to 5.55m3 per second or 2,592,000 seconds
    //Total pull size is 14,385,600 m3
    $totalPull = 5.55 * (3600.00 * 24.00 * 30.00);
    //Get the configuration for pricing calculations
    $config = $db->fetchRow('SELECT * FROM Config');

    if($firstQuan >= 1.00) {
	$firstPerc = $firstQuan / 100.00;
    } else {
	$firstPerc = $firstQuan;
    }
    if($secondQuan >= 1.00) {
	$secondPerc = $secondQuan / 100.00;
    } else {
	$secondPerc = $secondQuan;
    }
    if($thirdQuan >= 1.00) {
	$thirdPerc = $thirdQuan / 100.00;
    } else {
	$thirdPerc = $thirdQuan;
    }
    if($fourthQuan >= 1.00) {
	$fourthPerc = $fourthQuan / 100.00;
    } else {
	$fourthPerc = $fourthQuan;
    }

    if($firstOre != "None") {
        $m3Size = $db->fetchColumn('SELECT m3Size FROM ItemComposition WHERE Name= :name', array('name' => $firstOre));
        //Find the m3 value of the first ore
        $firstActualm3 = floor($firstPerc * $totalPull);
        //Calculate the units of the first ore
        $firstUnits = floor($firstActualm3 / $m3Size);
        //Get the unit price from the database
        $firstUnitPrice = $db->fetchColumn('SELECT UnitPrice  FROM OrePrices WHERE Name= :name', array('name'=> $firstOre));
        //Calculate the total price for the first ore
        $firstTotal = $firstUnits * $firstUnitPrice;
    } else {
        $firstTotal = 0.00;
    }

    if($secondOre != "None") {
        $m3Size = $db->fetchColumn('SELECT m3Size FROM ItemComposition WHERE Name= :name', array('name' => $secondOre));
        //find the m3 value of the second ore
        $secondActualm3 = floor($secondPerc * $totalPull);
        //Calculate the units of the second ore
        $secondUnits = floor($secondActualm3 / $m3Size);
        //Get the  unit price from the database
        $secondUnitPrice = $db->fetchColumn('SELECT UnitPrice FROM OrePrices WHERE Name= :name', array('name' => $secondOre));
        //calculate the total price for the second ore
        $secondTotal = $secondUnits * $secondUnitPrice;
    } else {
        $secondTotal = 0.00;
    }

    if($thirdOre != "None") {
        $m3Size = $db->fetchColumn('SELECT m3Size FROM ItemComposition WHERE Name= :name', array('name' => $thirdOre));
        //find the m3 value of the third ore
        $thirdActualm3 = floor($thirdPerc * $totalPull);
        //calculate the units of the third ore
        $thirdUnits = floor($thirdActualm3 / $m3Size);
        //Get the unit price from the database
        $thirdUnitPrice = $db->fetchColumn('SELECT UnitPrice FROM OrePrices WHERE Name= :name', array('name' => $thirdOre));
        //calculate the total price for the third ore
        $thirdTotal = $thirdUnits * $thirdUnitPrice;
    } else {
        $thirdTotal = 0.00;
    }

    if($fourthOre != "None") {
        $m3Size = $db->fetchColumn('SELECT m3Size FROM ItemComposition WHERE Name= :name', array('name' => $fourthOre));
        //Find the m3 value of the fourth ore
        $fourthActualm3 = floor($fourthPerc * $totalPull);
        //Calculate the units of the fourth ore
        $fourthUnits = floor($fourthActualm3 / $m3Size);
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
   
    //Return the rental price to the caller
    return $rentalPrice;

}
