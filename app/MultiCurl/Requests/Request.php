<?php

namespace MultiCurl\Requests;

class Request {
  protected $headers = null;

  public function __construct(){
    $arguments = func_get_args();
    if(!(count($arguments) === 0)){
      $this->__set($arguments);
    }
  }

  public function __set($key, $val=null){
    if(is_array($key)){
      // If this was passed in as an array, it's part of func_get_args,
      // so we need to extract the actual array from the arguments array.
      $key = $key[0];
      foreach($key as $k=>$kv){
        if(is_numeric($k)){
          $kk = array_keys(get_object_vars($this))[$k];
          $this->$kk = $kv;
        }elseif(property_exists($this, $k)){
          $this->$k = $kv;
        }else{
          trigger_error(
            'Undefined property (' . $k . ')'
          );
        }
      }
    }else{
      if(property_exists($this, $key)){
        $this->$key = $val;
      }else{
        trigger_error(
          'Undefined property (' + $key + ')'
        );
      }
    }
  }

  public function __get($key=null){
    if(is_null($key)){
      return get_object_vars($this);
    }else{
      if(property_exists($this, $key)){
        return $this->$key;
      }else{
        trigger_error(
          'Undefined property (' + $key + ')'
        );
        return null;
      }
    }
  }

  /**
   *  Header functions. Interacts with headers individually.
   */

  /**
   *  Add a header.
   *  @param $key The header name.
   *  @param $val The header value.
   */
  public function addHeader($key, $val){
    $this->__set('header', [$key, $val]);
  }

  /**
   *  Get the value of a header.
   *  @param $key The name of the header.
   *  @return string
   */
  public function getHeader($key){
    return $this->header[$key];
  }

  /**
   *  Remove a header.
   *  @param $key The name of the header.
   */
  public function removeHeader($key){
    unset($this->header[$key]);
  }

  public function __toString(){
    return print_r($this->__get(), true);
  }

  public function __destruct(){

  }
}
