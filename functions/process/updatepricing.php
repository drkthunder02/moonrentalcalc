<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function UpdateItemPricing() {
    
    if(php_sapi_name() != 'cli') {
        $browser = true;
        printf("Running price update from browser.<br>");
    } else {
        $browser = false;
        printf("Running price update from command line.\n");
    }

    $db = DBOpen();

    //Get the configuration from the config table
    $config = $db->fetchRow('SELECT * FROM Config');
    //Calculate refine rate
    $refineRate = $config['RefineRate'] / 100.00;

    //Calculate the current time
    $time = time();
    //Get the max time from the database
    $maxTime = $db->fetchColumn('SELECT MAX(Time) FROM Prices WHERE ItemId= :id', array('id' => 34));
    //Get the price of the basic minerals
    $tritaniumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 34, 'time' => $maxTime));
    $pyeritePrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 35, 'time' => $maxTime));
    $mexallonPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 36, 'time' => $maxTime));
    $isogenPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 37, 'time' => $maxTime));
    $nocxiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 38, 'time' => $maxTime));
    $zydrinePrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 39, 'time' => $maxTime));
    $megacytePrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 40, 'time' => $maxTime));
    $morphitePrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 11399, 'time' => $maxTime));
    $heliumIsotopesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16274, 'time' => $maxTime));
    $nitrogenIsotopesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 17888, 'time' => $maxTime));
    $oxygenIsotopesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 17887, 'time' => $maxTime));
    $hydrogenIsotopesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 17889, 'time' => $maxTime));
    $liquidOzonePrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16273, 'time' => $maxTime));
    $heavyWaterPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16272, 'time' => $maxTime));
    $strontiumClathratesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16275, 'time' => $maxTime));
    //Get the price of the moongoo
    $atmosphericGasesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16634, 'time' => $maxTime));
    $evaporiteDepositsPirce = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16635, 'time' => $maxTime));
    $hydrocarbonsPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16633, 'time' => $maxTime));
    $silicatesPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16636, 'time' => $maxTime));
    $cobaltPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16640, 'time' => $maxTime));
    $scandiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16639, 'time' => $maxTime));
    $titaniumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16638, 'time' => $maxTime));
    $tungstenPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16637, 'time' => $maxTime));
    $cadmiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16643, 'time' => $maxTime));
    $platinumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16644, 'time' => $maxTime));
    $vanadiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16642, 'time' => $maxTime));
    $chromiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16641, 'time' => $maxTime));
    $technetiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16649, 'time' => $maxTime));
    $hafniumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16648, 'time' => $maxTime));
    $caesiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16647, 'time' => $maxTime));
    $mercuryPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16646, 'time' => $maxTime));
    $dysprosiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16650, 'time' => $maxTime));
    $neodymiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16651, 'time' => $maxTime));
    $promethiumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16652, 'time' => $maxTime));
    $thuliumPrice = $db->fetchColumn('SELECT Price FROM Prices WHERE ItemId= :id AND Time= :time', array('id' => 16653, 'time' => $maxTime));
    //Get the item compositions
    $items = $db->fetchRowMany('SELECT Name,ItemId FROM ItemComposition');
    //Go through each of the items and update the price
    foreach($items as $item) {
        //Get the item composition
        $composition = $db->fetchRow('SELECT * FROM ItemComposition WHERE ItemId= :id', array('id' => $item['ItemId']));
        //Calculate the Batch Price
        $batchPrice = ( ($composition['Tritanium'] * $tritaniumPrice) +
                        ($composition['Pyerite'] * $pyeritePrice) +
                        ($composition['Mexallon'] * $mexallonPrice) +
                        ($composition['Isogen'] * $isogenPrice) +
                        ($composition['Nocxium'] * $nocxiumPrice) +
                        ($composition['Zydrine'] * $zydrinePrice) +
                        ($composition['Megacyte'] * $megacytePrice) + 
                        ($composition['Morphite'] * $morphitePrice) +
                        ($composition['HeavyWater'] * $heavyWaterPrice) +
                        ($composition['LiquidOzone'] * $liquidOzonePrice) +
                        ($composition['NitrogenIsotopes'] * $nitrogenIsotopesPrice) +
                        ($composition['HeliumIsotopes'] * $heliumIsotopesPrice) + 
                        ($composition['HydrogenIsotopes'] * $hydrogenIsotopesPrice) +
                        ($composition['OxygenIsotopes'] * $oxygenIsotopesPrice) +
                        ($composition['StrontiumClathrates'] * $strontiumClathratesPrice) +
                        ($composition['AtmosphericGases'] * $atmosphericGasesPrice) +
                        ($composition['EvaporiteDeposits'] * $evaporiteDepositsPirce) +
                        ($composition['Hydrocarbons'] * $hydrocarbonsPrice) +
                        ($composition['Silicates'] * $silicatesPrice) +
                        ($composition['Cobalt'] * $cobaltPrice) +
                        ($composition['Scandium'] * $scandiumPrice) +
                        ($composition['Titanium'] * $titaniumPrice) +
                        ($composition['Tungsten'] * $tungstenPrice) +
                        ($composition['Cadmium'] * $cadmiumPrice) +
                        ($composition['Platnium'] * $platinumPrice) +
                        ($composition['Vanadium'] * $vanadiumPrice) +
                        ($composition['Chromium'] * $chromiumPrice)+
                        ($composition['Technetium'] * $technetiumPrice) +
                        ($composition['Hafnium'] * $hafniumPrice) +
                        ($composition['Caesium'] * $caesiumPrice) +
                        ($composition['Mercury'] * $mercuryPrice) +
                        ($composition['Dysprosium'] * $dysprosiumPrice) +
                        ($composition['Neodymium'] * $neodymiumPrice) + 
                        ($composition['Promethium'] * $promethiumPrice) +
                        ($composition['Thulium'] * $thuliumPrice));
        //Calculate the batch price with the refine rate included
        //Batch Price is base price for everything
        $batchPrice = $batchPrice * $refineRate;
        //Calculate the unit price
        $price = $batchPrice / $composition['BatchSize'];
        //Calculate the m3 price
        $m3Price = $price / $composition['m3Size'];
        //Insert the prices into the Pricees table
        $db->insert('OrePrices', array(
            'Name' => $composition['Name'],
            'ItemId' => $composition['ItemId'],
            'BatchPrice' => $batchPrice,
            'UnitPrice' => $price,
            'm3Price' => $m3Price,
            'Time' => $time
        ));   
    }

    DBClose($db);

}

?>