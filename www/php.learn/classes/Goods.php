<?php

abstract class Goods {
  const GOODS_HTML = 'HTML';
  const GOODS_JSON = 'JSON';
  const GOODS_CSV  = 'CSV';
  const GOODS_ARRAY= 'ARRAY';

  public $title;
  public $price; 

  public function __construct($title, $price = 0 ){
    $this->title = $title;
    $this->price = $price;
    // echo 'Создан экземпляр класса ' . __CLASS__ . '<hr />';
  }

  abstract public function get();
}
