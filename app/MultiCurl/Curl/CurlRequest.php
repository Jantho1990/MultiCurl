<?php

namespace MultiCurl\Curl;
use MultiCurl\Request as Request;

/**
 *  A request object MultiCurl uses to set up curl requests.
 */

class CurlRequest extends Request {
  private $url = null;
  private $curl_opts = null;

  public function __construct(){
    // Call the parent constructor.
    call_user_func_array(parent::__construct, func_get_args());

  }

}
