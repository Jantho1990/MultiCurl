<?php

namespace MultiCurl\Curl;
use MultiCurl\Requests\Request as Request;

/**
 *  A request object MultiCurl uses to set up curl requests.
 */

class CurlRequest extends Request {
  protected $url = null;
  protected $curl_opts = null;

}
