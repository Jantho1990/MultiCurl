<?php

namespace MultiCurl;

use MultiCurl\Curl\CurlHandle as CurlHandle;
use MultiCurl\Curl\CurlRequest as CurlRequest;
use MultiCurl\Curl\CurlResponse as CurlResponse;
use MultiCurl\ResponsesHandler as ResponsesHandler;

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
  private $ResponsesHandler = null;

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

    // Set the responses handler.
    $this->ResponsesHandler = new ResponsesHandler;

    // Add the created curl handles to the multi object.
    //$this->addCurlMultiHandles($this->handles);
    // Taking this out so we can precisely control when we
    // add handles (this will allow batch_limit to be
    // enforced).

  }

  /**
   *  Set the urls.
   *  @param $requests A CurlRequest or array of CurlRequest objects.
   */
  private function setRequests($requests){
    if(is_array($requests)){
      foreach($requests as $request){
        $this->requests[count($this->requests)] = $request;
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
   *  Set configuration options. Options are as follows:
   *  @param return_headers_as_array Header values are converted to an array.
   *  @param idsep Sets the id separator value.
   *  @param batch_limit The maximum number of requests to process at once.
   */
  private function setConfigOptions($config){
    $master_config = [
      'return_headers_as_array' => 0,
      'idsep' => ']MULTICURL]',
      'batch_limit' => 10
    ];
    $this->config = $master_config;
    foreach($config as $c=>$conf){
      $this->config[$c] = $conf;
    }
  }

  /**
   *  Create curl handles for requests.
   */
  public function createCurlHandles($requests){
    if(is_array($requests)){
      foreach($requests as $r=>$request){
        $curlHandle = $this->createCurlHandle(
          $request,
          $this->hid,
          $this->config['idsep']
        );
        $this->handles[$this->hid++] = $curlHandle;
      }
    }
  }

  /**
   *  Create a CurlHandle from a CurlRequest object.
   */
  public function createCurlHandle($request, $id, $idsep){
    return new CurlHandle($request, $id, $idsep);
  }

  /**
   *  Execute handles.
   */
  public function execute(){
    // Parts of this method inspired by:
    // www.onlineaspect.com/2009/01/26/how-to-use-curl_multi-without-blocking/

    // Add the inital batch of handles, respecting batch_limit.
    for($i = 0; $i < $this->config['batch_limit']; $i++){
      $handle = $this->handles[$i];
      curl_multi_add_handle($this->mh, $handle->handle());
    }

    // Process the requests.
    $active = null;
    do{
      $mrc = curl_multi_exec($this->mh, $running);
      if($mrc != CURLM_OK){break;}

      // Request finished -- Send to the process handler.
      while($done = curl_multi_info_read($mh)){
        // Process the result and take care of creating
        // any necessary CurlResponse objects.
        // $result will tell MultiCurl what actions to
        // take after the response is processed.
        $result = $this->ResponsesHandler
          ->processResponse($handle, $this);
        // Figure out what to do based on the value of
        // $result.
        switch($result){
          case 'success':
            // Remove handle from the queue and add a
            // new handle to the queue.

            break;
          case 'redirect':
            // Add the handle back to the queue. Based on
            // config, determine if it should be added back
            // now or at the end of the queue.

            break;
          case 'error':
            // Something went wrong, remove handle from the
            // queue.

            break;
          case 'retry':
            // Handle 429s and other requests that are not
            // redirects, but that should be added back to
            // the queue.

            break;
          case 'continue':
            // This will handle Code 100 requests.

            break;
          default:
            // ...whoops.
            trigger_error("Unexpected result: $result");
        }

      }
    }while($running);

    //$this->createCurlResponses();

    // TODO: add curl_multi_info_read.

  }

  /**
   *  Get id out of curlopt_private.
   */
  private function getHandleId($mh_handle){
    $private = curl_getinfo($mh_handle, CURLINFO_PRIVATE);
    $id_loc = strpos($private, $this->config['idsep']);
    return susbtr($private, 0, $id_loc);
  }

  /**
   *  Returns the appropriate CurlHandle object based on
   *  the stored private value in $mh_handle.
   */
  private function getCurlHandleObject($mh_handle){
    $id = $this->getHandleId($mh_handle);
    return $this->handles[$id];
  }

  /**
   *  Success Handler.
   */
  private function successHandler($handle){

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
    $responseData = $this->processContent($handle);
    $curlResponse = new CurlResponse([
      'content' => $responseData['content'],
      'statusCode' => curl_getinfo($handle->handle(), CURLINFO_HTTP_CODE),
      'headers' => $responseData['headers']
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
   *  Extract the response header and return an array with
   *  header and content strings.
   *  @param $handle A curl handle.
   *  @return array
   */
  public function processContent($handle){
    $hs = curl_getinfo($handle->handle(), CURLINFO_HEADER_SIZE);
    $content = curl_multi_getcontent($handle->handle());
    $headers = substr($content, 0, $hs);
    if($this->config['return_headers_as_array'] === 1){
      echo "This will cause return headers to be returned as an array. But not today. :P\n";
    }
    $content = substr($content, $hs);
    return [
      'headers' => $headers,
      'content' => $content
    ];
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
