<?php

/* 
 *  W4RP Services
 *  GNU Public License
 */

//PHP Debug Mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Get the required files to run the site
require_once __DIR__.'/functions/registry.php';
    
$session = new W4RP\session();

$_SESSION['LoginState'] = false;
session_destroy();

$location = 'http://' . $_SERVER['HTTP_HOST'];
$location = $location . dirname($_SERVER['PHP_SELF']) . '/index.php';
header("Location: $location");
die();