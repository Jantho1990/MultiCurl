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
$init2 = [
  'headers' => ['test1' => 'test2'],
  'url' => 'https://developer.mozilla.org/en-US/',
  'curl_opts' => [
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1
  ]
];
$req = new CurlRequest($init);
$req2 = new CurlRequest($init2);
//goEcho($req->url);
//goEcho($req->headers);
//goEcho($req);
$mc = new MultiCurl($req);
$mc->execute();
//var_dump($mc->getContentFromHandles());
var_dump($mc->getResponses());
$mc2 = new MultiCurl([$req, $req2]);
$mc2->execute();
var_dump($mc2->getResponses());
