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

  /**
   *  Return the raw curl handle.
   *  @return curl object
   */
  public function getHandle(){
    return $this->ch;
  }

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
    foreach($curl_opts as $co=>$curl_opt){
      switch($co){
        case 'CURLOPT_PRIVATE':
          // Not setting this because that's what id is for.
          break;
        case 'CURLOPT_URL':
          // Use $url to set this.
          break;
        default:
          curl_setopt($ch, $co, $curl_opt);
      }
    }
    return $this;

  }

  public function __destruct(){
    curl_close($this->ch);
  }

}
