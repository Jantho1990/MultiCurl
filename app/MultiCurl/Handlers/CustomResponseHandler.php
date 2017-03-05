<?php

/**
 *  A custom response handler object.
 */
class CustomResponseHandler {

  public $name = null;
  public $function = null;

  public function __construct($name, $function){
    $this->name = $name;
    $this->function = $function;
  }

}
