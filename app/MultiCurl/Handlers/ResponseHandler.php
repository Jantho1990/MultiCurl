<?php

class ResponseHandler {

  private $_handlers = [];

  public function __construct($default){
    $_handlers['default'] = $default;
  }

  public function addResponseHandler($name, $function){
    $_handlers[$name] = $function;
  }

  public function removeResponseHandler($name){
    if(array_key_exists($name, $this->_handlers)){
      unset($this->_handlers[$name]);
    }else{
      trigger_error('Handler does not exist.');
      return false;
    }
  }

}
