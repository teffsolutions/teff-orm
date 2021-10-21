<?php 

class Resource {

  protected $model;

  public function __construct($model){

    $_arr = $this->toArray();

    $obj = new $model();

    $_response = array();

    foreach ($_arr as $_k => $_v) {
      $_response[$_v]=$obj->{$_k};
    }

    // header();
    return json_encode($_response);
  }

  protected function toArray(){
    return array();
  }
}