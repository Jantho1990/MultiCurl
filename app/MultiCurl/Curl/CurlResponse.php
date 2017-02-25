<?php

namespace MultiCurl\Curl;
use MultiCurl\Requests\Request as Request;

/**
 *  The response of a MultiCurl curl request.
 */

class CurlResponse extends Request {

  protected $content = null;
  protected $statusCode = null;

}
