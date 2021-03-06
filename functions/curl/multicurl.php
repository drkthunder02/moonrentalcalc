<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function MultiCurl($data = array(), $options = array()) {
    //Array of cURL handles
    $urls = array();
    
    //Data to be returned
    $result = array();
    $results = array();
    
    //Multi cURL handle
    $mh = curl_multi_init();
    
    //Loop through the $data and create curl handles then add them to the multi-handle for curl
    foreach($data as $key => $value) {
        $curls[$key] = curl_init();
        curl_setopt($curls[$key], CURLOPT_URL, $value);
        curl_setopt($curls[$key], CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curls[$key], CURLOPT_HTTPGET, true);
        curl_setopt($curls[$key], CURLOPT_RETURNTRANSFER, 1);
        //Extra Options
        if(!empty($options)) {
            curl_setopt_array($curls[$key], $options);
        }

        //Add the handles
        curl_multi_add_handle($mh, $curls[$key]);
    }
    
    //Execute the cURL handles
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);
    
    //Get the content and remove the handles
    foreach($curls as $key => $value) {
        $result[$key] = curl_multi_getcontent($value);
        curl_multi_remove_handle($mh, $value);
    }
    
    //Once all the calls are completed close the multi curl channel
    curl_multi_close($mh);
    
    return $result;
}
