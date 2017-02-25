<?php

namespace MultiCurl\Curl;
use MultiCurl\Response as Response;

/**
 *  The response of a MultiCurl curl request.
 */

class CurlResponse extends Response {

  private $content = null;
  private $statusCode = null;

  public function __construct(){
    // Call the parent constructor.
    call_user_func_array(parent::__construct, func_get_args());

  }

}
