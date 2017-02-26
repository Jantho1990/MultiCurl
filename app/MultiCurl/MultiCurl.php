<?php

namespace MultiCurl;

use MultiCurl\Curl\CurlHandle as CurlHandle;
use MultiCurl\Curl\CurlRequest as CurlRequest;
use MultiCurl\Curl\CurlResponse as CurlResponse;

/**
 *  A curl wrapper class that features curl_multi.
 *  @param $requests A singular or array of CurlRequest objects.
 *  @param $config An array of configuration options.
 */
class MultiCurl {

  private $handles = [];
  private $hid = 0; // Counter for handle private IDs.
  private $requests = [];
  private $config = [];
  private $mh = null;

  public function __construct($requests, $config=null){
    // Validate data.

    // Set the requests.
    $this->setRequests($requests);

    // Set configuration options.
    $this->setConfigOptions($config);

    // Create the curl_multi handle.
    $mh = $this->mh;
    $mh = \curl_multi_init();

    // Create curl handles for each request.
    $this->createCurlHandles($this->requests);

  }

  /**
   *  Set the urls.
   *  @param $requests A CurlRequest or array of CurlRequest objects.
   */
  private function setRequests($requests){
    $r = 0;
    if(is_array($requests)){
      foreach($requests as $request){
        $this->$requests[$r++] = $request;
      }
    }else{
      $this->requests[count($this->requests)] = $requests;
    }
  }

  /**
   *  Public alias of setRequests.
   *  @param $request A CurlRequest or array of CurlRequest objects.
   */
  public function addRequest($request){
    return $this->setRequests($request);
  }

  /**
   *  Set configuration options.
   */
  private function setConfigOptions(){
    $master_config = [

    ];

  }

  /**
   *  Create curl handles for requests.
   */
  private function createCurlHandles($requests){
    if(is_array($requests)){
      foreach($requests as $r=>$request){
        $this->createCurlHandle($request);
      }
    }
  }

  /**
   *  Create a CurlHandle from a CurlRequest object.
   */
  private function createCurlHandle($request){
    $curlRequest = new CurlHandle($request, $this->hid++);
  }

  /**
   *  Build curl_multi handles.
   */
  public function addCurlMultiHandles($handles=null){
    // Validate data.
    if($handles === null){
      trigger_error('No handles passed in.');
      return false;
    }

    // Loop through urls and create curl handles.
    //foreach($handles as)

  }

  /**
   *  Execute a query.
   */
  public function execute(){

  }

}
