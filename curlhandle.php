<?php

/**
 *  A single curl handle.
 */
class CurlHandle {

  // This is the unique ID of the CurlHandle.
  // We use this to identify the handle during the
  // MultiCurl process.
  private $id = null;

  /**
   *  Return the id of this handle.
   */
  public function getId(){
    return $this->id;
  }

  // The curl handle itself.
  private $ch = null;

  public function __construct($url, $curl_opts, $id){
    // Validate arguments.
    $args = func_get_args();
    foreach($args as $arg){
      if(!isset($arg)){
        throw new Exception('Undefined argument.');
      }
    }

    // Create the curl handle.
    $ch = $this->ch;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $this->id = $id;
    curl_setopt($ch, CURLOPT_PRIVATE, $id);

  }

  public function __destruct(){

  }

}
