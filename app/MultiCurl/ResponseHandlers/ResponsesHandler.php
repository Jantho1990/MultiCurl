<?php

namespace MultiCurl;

use MultiCurl\ResponseHandler as ResponseHandler;
use MultiCurl\CustomResponseHandler as CustomResponseHandler;

class ResponsesHandler {

  private $_handlers = null;

  /**
   *  Success response handler.
   *  @param $handle A curl handle.
   *  @param $mh The MultiCurl object.
   */
  private function successHandler($handle, $mh){
    // Extract headers from the rest of the data, unless we
    // have been explicitly told not to send headers.

    // Create a CurlResponse object and store it in the
    // MultiCurl object.

  }

  /**
   *  Error response handler.
   *  @param $handle A CurlHandle object.
   *  @param $mh The MultiCurl object.
   */
  private function errorHandler($handle, $mh){
    // Extract headers from the rest of the data, unless we
    // have been explicitly told not to send headers.

    // Create a CurlResponse object and store it in the
    // MultiCurl object.

  }

  /**
   *  Error response handler.
   *  @param $handle A CurlHandle object.
   *  @param $mh The MultiCurl object.
   */
  private function redirectHandler($handle, $mh){
    // Extract headers from the rest of the data, unless we
    // have been explicitly told not to send headers.

    // Create a CurlResponse object and store it in the
    // MultiCurl object.

  }

  /**
   *  Error response handler.
   *  @param $handle A CurlHandle object.
   *  @param $mh The MultiCurl object.
   */
  private function continueHandler($handle, $mh){
    // Extract headers from the rest of the data, unless we
    // have been explicitly told not to send headers.

    // Create a CurlResponse object and store it in the
    // MultiCurl object.

  }

  /**
   *  Error response handler.
   *  @param $handle A CurlHandle object.
   *  @param $mh The MultiCurl object.
   */
  private function retryHandler($handle, $mh){
    // Extract headers from the rest of the data, unless we
    // have been explicitly told not to send headers.

    // Create a CurlResponse object and store it in the
    // MultiCurl object.

  }

  /**
   *  Add a custom response handler.
   *  @param $name The name of the handler.
   *  @param $code The status code the handler should respond to.
   *  @param $function The handler function.
   *  @param $arguments An array of variables to pass into your handler function.
   *  @return void.
   */
  public function addHandler($name, $code, $function, $arguments){

  }

  /**
   *  Remove a custom handler. If you want to remove the default handler, call removeDefaultHandler.
   *  @param $name The name of the custom handler.
   *  @param $code The status code with the custom handler.
   *  @return void
   */
  public function removeHandler($name, $code){
      // Verify the custom handler exists.

      // Remove the custom handler.
  }

  /**
   *  Removes the default handler for a status code.
   *  @param $code The status code whose default handler you want to remove.
   *  @return void
   */
  public function removeDefaultHandler($code){

  }

  public function __construct(){
    // Set _handlers with all existing http status codes.
    $this->_handlers = [
      100 => [
        'default' => $this->continueHandler
      ],
      101 => [
        'default' => $this->continueHandler
      ],
      103 => [
        'default' => $this->continueHandler
      ],
      200 => [],
      201 => [],
      202 => [],
      203 => [],
      204 => [],
      205 => [],
      206 => [],
      207 => [],
      208 => [],
      226 => [],
      300 => [],
      301 => [],
      302 => [],
      303 => [],
      304 => [],
      305 => [],
      307 => [],
      308 => [],
      400 => [],
      401 => [],
      402 => [],
      403 => [],
      404 => [],
      405 => [],
      406 => [],
      407 => [],
      408 => [],
      409 => [],
      410 => [],
      411 => [],
      412 => [],
      413 => [],
      414 => [],
      415 => [],
      416 => [],
      417 => [],
      418 => [],
      421 => [],
      422 => [],
      423 => [],
      424 => [],
      426 => [],
      428 => [],
      429 => [],
      431 => [],
      451 => [],
      500 => [],
      501 => [],
      502 => [],
      503 => [],
      504 => [],
      505 => [],
      506 => [],
      507 => [],
      508 => [],
      510 => [],
      511 => []
    ];
  }

  public function processResponse($handle){
    $info = curl_getinfo($handle);
    call_user_func_array(
      $this->_handlers[$info['http_code']],
      [$handle]
    );
    $code = $info['http_code'];
    $responseHandler = $this->_handlers[$code];
    foreach($responseHandler as $handler){
      call_user_func_array(
        $handler['function'],
        $handler['arguments']
      );
    }
  }

}
