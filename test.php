<?php

/**
 *  Rudimentary page for testing functions.
 */

use MultiCurl\MultiCurl as MultiCurl;
use MultiCurl\Curl\CurlHandle as CurlHandle;
use MultiCurl\Requests\Request as Request;

require_once('app/start.php');

/**
 *  Simple logging function that automatically adds a line break.
 */
function goEcho($val){
  echo "$val\n";
}

goEcho("I have loaded.");
$mc = new MultiCurl();
$ch = new CurlHandle();
$req = new Request();
