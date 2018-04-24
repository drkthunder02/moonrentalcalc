<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function FuzzworkPrice($url) {
    //Initialize the curl request
    $ch = curl_init();
    //Set the curl options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //Execute the curl
    $result = curl_exec($ch);
    //Get the resultant data and decode the json request
    $data = json_decode($result, true);
    
    //Return the array of data
    return $data;
}