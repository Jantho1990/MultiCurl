<?php

/**
 *  A curl wrapper class that features curl_multi.
 *  @param $urls The url or urls you want to query.
 *  @param $config An array of preset configuration options.
 */
class MultiCurl {

  private $urls = [];
  private $responses = [];

  public function __construct($urls, $config){

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
   *  Execute a query.
   */
  public function execute(){

  }

}
