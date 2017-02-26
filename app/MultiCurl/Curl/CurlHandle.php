<?php

namespace MultiCurl\Curl;

/**
 *  A single curl handle.
 */
class CurlHandle {

  // This is the unique ID of the CurlHandle.
  // We use this to identify the handle during the
  // MultiCurl process.
  private $id = null;
  private $idsep = ']MULTICURL]';

  /**
   *  Return the id of this handle.
   */
  public function id(){
    return $this->id;
  }

  /**
   *  Get id out of curlopt_private.
   */
  private function getId($ch){
    $private = curl_getinfo($ch, CURLINFO_PRIVATE);
    $id_loc = strpos($private, $this->idsep);
    return susbtr($private, 0, $id_loc);
  }

  /**
   * Get the private value independent of the ID.
   */
  private function getPrivate($ch){
    $private = curl_getinfo($ch, CURLINFO_PRIVATE);
    $id_loc = strpos($private, $this->idsep);
    return substr($private, ($id_loc + strlen($this->idsep)));
  }

  // The curl handle itself.
  private $ch = null;

  /**
   *  Return the raw curl handle.
   *  @return curl object
   */
  public function handle(){
    return $this->ch;
  }

  public function __construct($request, $id){
    // Validate arguments.
    $args = func_get_args();
    foreach($args as $arg){
      if(!isset($arg)){
        throw new Exception('Undefined argument.');
      }
    }

    // Create the curl handle.
    $this->ch = curl_init();
    curl_setopt($this->ch, CURLOPT_URL, $request->url);
    curl_setopt($this->ch, CURLOPT_PRIVATE, $this->id . $this->idsep);
    foreach($request->curl_opts as $co=>$curl_opt){
      switch($co){
        case CURLOPT_PRIVATE:
          // We need to set ID]], followed by the actual value.
          $private = $this->id . $this->idsep . $curl_opt;
          curl_setopt($this->ch, CURLOPT_PRIVATE, $private);
          break;
        case CURLOPT_URL:
          // Use $url to set this.
          break;
        default:
          curl_setopt($this->ch, $co, $curl_opt);
      }
    }
    return $this;

  }

  public function __destruct(){
    curl_close($this->ch);
  }

}
