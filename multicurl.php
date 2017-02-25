<?php

namespace MultiCurl;

use MultiCurl\CurlHandle as CurlHandle;

/**
 *  A curl wrapper class that features curl_multi.
 *  @param $urls The url or urls you want to query.
 *  @param $config An array of preset configuration options.
 */
class MultiCurl {

  private $urls = [];
  private $requests = [];
  private $config = [];
  private $master_config = [];
  private $curl_handles = [];
  private $mh = null;

  public function __construct($urls, $config){
    // Validate data.

    // Set the urls.
    $this->setUrls($urls);

    // Set configuration options.
    $this->setConfigOptions($config);

    // Create the curl_multi handle.
    $mh = $this->mh;
    $mh = curl_multi_init();

  }

  /**
   *  Set the urls.
   */
  private function setUrls($urls){
    $u = 0;
    foreach($urls as $url){
      $this->urls[$u++] = $url;
    }
  }

  /**
   *  Set configuration options.
   */
  private function setConfigOptions(){
    $master_config = [
      'method' => 'get',
      'curl_opts' => []
    ];

  }

  /**
   *  Build curl handles.
   */
  public function addCurlMultiHandles($handles=null){
    // Validate data.
    if($handles === null){
      trigger_error('No handles passed in.');
      return false;
    }

    // Loop through urls and create curl handles.
    foreach($handles as)

  }

  /**
   *  Execute a query.
   */
  public function execute(){

  }

}
