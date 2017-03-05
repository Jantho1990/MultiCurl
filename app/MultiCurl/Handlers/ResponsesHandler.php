<?php

namespace MultiCurl;

use MultiCurl\ResponseHandler as ResponseHandler;
use MultiCurl\CustomResponseHandler as CustomResponseHandler;

class ResponsesHandler {

  private $_handlers = [];

  // These are the default response handler functions.

  private function responseHandlerUndefined(){
    trigger_error('No response for status code ' + $info['http_code']);
  }

  private function responseHandler200(){

  }

  public function __construct(){
    $this->_handlers[100] = new ResponseHandler($this->responseHandlerUndefined);
    $this->_handlers[101] = new ResponseHandler($this->responseHandlerUndefined);
    $this->_handlers[103] = new ResponseHandler($this->responseHandlerUndefined);
    $this->_handlers[200] = new ResponseHandler($this->responseHandler200);
  }

  public function processResponse($handle){
    $info = curl_getinfo($handle);
    call_user_func_array(
      $this->_handlers[$info['http_code']],
      [$handle]
    );
    switch($info['http_code']){
      case 100:
        trigger_error('No response for status code ' + $info['http_code']);
        break;
      case 101:
        trigger_error('No response for status code ' + $info['http_code']);
        break;
      case 103:
        trigger_error('No response for status code ' + $info['http_code']);
        break;
      case 200:
        $this->_handler[200]
        break;
      default:
        trigger_error('Unknown HTTP status code (' + $info['http_code'] + ')');
    }
  }

}
