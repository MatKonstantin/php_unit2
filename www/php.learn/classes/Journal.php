<?php

class Journal extends Goods implements IGoods  {
  public $author;
  public $description;
  public static $counter = 0;

  public function __construct($title, $author, $description = '', $price = 0  ){
    parent::__construct($title, $price);
    self::$counter++;
    $this->author = $author;
    $this->description = $description;   
    __FUNCTION__;
    __CLASS__;
    
    // echo 'Создан экземпляр класса ' . __CLASS__ . '<hr />';
  }
  public function __destruct( ){
    // echo 'Удалён экземпляр класса ' . __CLASS__ . '<hr />';
  } 

  public function get($format = Goods::GOODS_HTML){
    $method = 'get' . $format;
    return $this->$method();
  }   

  final public function getHTML(){    
    return "<h3>{$this->title}</h3>
    <div>Автор: {$this->author}</div>
    <div>Описание: {$this->description}</div>
    <div>Цена: {$this->price}</div>
    ";
  }

  public function getCSV(){    
    return "CSV";
  }
  public function getJSON(){    
    return "JSON";
  }
  public function getArray(){    
    return "Array";
  }
}