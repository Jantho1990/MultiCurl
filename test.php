<?php

/**
 *  Rudimentary page for testing functions.
 */

use MultiCurl\MultiCurl as MultiCurl;
use MultiCurl\Curl\CurlHandle as CurlHandle;
use MultiCurl\Requests\Request as Request;
use MultiCurl\Curl\CurlRequest as CurlRequest;

require_once('app/start.php');

/**
 *  Simple logging function that automatically adds a line break.
 */
function goEcho($val){
  echo "$val\n";
}

goEcho("I have loaded.");
//$mc = new MultiCurl();
//$ch = new CurlHandle();
$init = [
  'headers' => ['test1' => 'test2'],
  'url' => 'http://www.doihaveinternet.com/',
  'curl_opts' => [
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1
  ]
];
$req = new CurlRequest($init);
//goEcho($req->url);
//goEcho($req->headers);
//goEcho($req);
$mc = new MultiCurl($req);
$mc->execute();
var_dump($mc->getContentFromHandles());
