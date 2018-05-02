<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../functions/registry.php';

//Open a database connection
$db = DBOpen();

$ItemIDs = array(
    "Tritanium" => 34,
    "Pyerite" => 35,
    "Mexallon" => 36,
    "Isogen" => 37,
    "Nocxium" => 38,
    "Zydrine" => 39,
    "Megacyte" => 40,
    "Morphite" => 11399,
    "HeliumIsotopes" => 16274,
    "NitrogenIsotopes" => 17888,
    "OxygenIsotopes" => 17887,
    "HydrogenIsotopes" => 17889,
    "LiquidOzone" => 16273,
    "HeavyWater" => 16272,
    "StrontiumClathrates" => 16275,
    "AtmosphericGases" => 16634,
    "EvaporiteDeposits" => 16635,
    "Hydrocarbons" => 16633,
    "Silicates" => 16636,
    "Cobalt" => 16640,
    "Scandium" => 16639,
    "Titanium" => 16638,
    "Tungsten" => 16637,
    "Cadmium" => 16643,
    "Platinum" => 16644,
    "Vanadium" => 16642,
    "Chromium" => 16641,
    "Technetium" => 16649,
    "Hafnium" => 16648,
    "Caesium" => 16647,
    "Mercury" => 16646,
    "Dysprosium" => 16650,
    "Neodymium" => 16651,
    "Promethium" => 16652,
    "Thulium" => 16653,
);

$time = time();
$item = array();
//Get the json data for each ItemId from https://market.fuzzwork.co.uk/api/
//Base url is https://market.fuzzwork.co.uk/aggregates/?region=10000002&types=34
//Going to use curl for these requests
foreach($ItemIDs as $key => $value) {
    $url = 'https://market.fuzzwork.co.uk/aggregates/?region=10000002&types=' . $value;
    $item = FuzzworkPrice($url);
    $db->insert('Prices', array(
        'Name' => $key,
        'ItemId' => $value,
        'Price' => $item[$value]['sell']['median'],
        'Time' => $time
    ));
}

UpdateItemPricing();

//Close the database connection
DBClose($db);