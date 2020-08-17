<?php

class GoodsCollection {
  protected $goods = [];

  public function __construct( Array $goods ){
    $this->goods = $goods;
  }

  public function show(){
    echo "<p>Книг всего: " . Book::$counter . "</p>";
    echo "<p>Журналов всего: " . Journal::$counter . "</p>";
    for($i = 0; $i < count($this->goods); $i++){ 
      echo $this->goods[$i]->get(), '<hr />';
    }
  }

  public function __get($propertyName){
    $fn = function( $item ) use ($propertyName) {
      return $item instanceof $propertyName ? 1: 0;
    };
    return array_filter(
      $this->goods,
      $fn
    );
  }
}