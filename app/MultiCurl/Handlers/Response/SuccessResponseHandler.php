<?php

class SuccessResponseHandler {

  private $_handlers = null;

  public function __construct(){
    // Set the defaults.
    $_handlers = [
      
    ];
  }

  public function processResponse($code, $handle, $mh){
    switch($code){
      case 100:

        break;
      case 101:

        break;
      case 103:

        break;
      case 200:

        break;
      case 201:

        break;
      case 202:

        break;
      case 203:

        break;
      case 204:

        break;
      case 205:

        break;
      case 206:

        break;
      case 207:

        break;
      case 208:

        break;
      case 226:

        break;
      default:
        trigger_error("No response handler for status code $code!");
    }
  }

}
