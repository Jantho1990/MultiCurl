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
  private $responses = [];
  private $config = [];
  private $mh = null;

  public function __construct($requests, $config=null){
    // Validate data.

    // Set the requests.
    $this->setRequests($requests);

    // Set configuration options.
    $this->setConfigOptions($config);

    // Create the curl_multi handle.
    $this->mh = \curl_multi_init();

    // Create curl handles for each request.
    $this->createCurlHandles($this->requests);

    // Add the created curl handles to the multi object.
    $this->addCurlMultiHandles($this->handles);

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
        $curlHandle = $this->createCurlHandle($request);
        $this->handles[count($this->handles)] = $curlHandle;
      }
    }
  }

  /**
   *  Create a CurlHandle from a CurlRequest object.
   */
  private function createCurlHandle($request){
    return new CurlHandle($request, $this->hid++);
  }

  /**
   *  Build curl_multi handles.
   */
  public function addCurlMultiHandles($handles = null){
    // Validate data.
    if($handles === null){
      trigger_error('No handles passed in.');
      return false;
    }

    // Loop through urls and create curl handles.
    foreach($handles as $handle){
      curl_multi_add_handle($this->mh, $handle->handle());
    }

  }

  /**
   *  Execute handles.
   */
  public function execute(){
    // For now this will just run typical curl_multi action.
    // Pretty boring stuff, I know.
    // Soon we will remove this and add the ability to
    // read data while executing.
    $active = null;
    do{
      $mrc = curl_multi_exec($this->mh, $active);
      curl_multi_select($this->mh);
    }while($active > 0);

    $this->createCurlResponses();

    // TODO: add curl_multi_info_read.

  }

  /**
   *  Create CurlResponse objects from the handle results.
   */
  private function createCurlResponses(){
    foreach($this->handles as $handle){
      $curlResponse = $this->createCurlResponse($handle);
      $this->responses[count($this->responses)] = $curlResponse;
    }
  }

  /**
   *  Create a CurlResponse object.
   */
  private function createCurlResponse(CurlHandle $handle){
    $curlResponse = new CurlResponse([
      'content' => curl_multi_getcontent($handle->handle()),
      'statusCode' => curl_getinfo($handle->handle(), CURLINFO_HTTP_CODE)
    ]);
    return $curlResponse;
  }

  /**
   *  Get responses.
   */
  public function getResponses(){
    return $this->responses;
  }

  /**
   *  Get content from completed curl handles.
   *  This is mostly useful to make sure execution succeeded.
   */
  public function getContentFromHandles(){
    $ret = [];
    foreach($this->handles as $handle){
      array_push($ret, curl_multi_getcontent($handle->handle()));
    }
    return $ret;
  }

  public function __destruct(){
    foreach($this->handles as $h => $handle){
      curl_multi_remove_handle($this->mh, $handle->handle());
      unset($this->handles[$h]);
    }
    curl_multi_close($this->mh);
  }

}
