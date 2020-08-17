<?php

class View
{

  public $param = [];
  public function __construct( $param ){
    $this->param = $param;
  }
  public function render(){

    $booksTable = "";

    if( $this->param['books'] ){
      $booksTable = "<table border=1>";
      foreach($this->param['books'] as $idbook => $book){
        $booksTable .= "<tr>";    
        $booksTable .= "<td>" . $idbook;    
        $booksTable .= "<td>" . $book->title;
        $booksTable .= "<td>" . $book->author;
        $booksTable .= "<td>" . $book->description;
        $booksTable .= "<td>" . $book->price;
        $booksTable .= "<td><a href='?add=$idbook'>В корзину</a>";
      }
      $booksTable .= "</table>";
    }    

    return  
      '<nav>' .
      '<a href="/index/">Каталог</a> ' .
      '<a href="/basket/">Корзина</a> ' .
      '<a href="/about/">О нас</a> ' .
      '<a href="/login/">Войти</a> ' .
      '</nav>' .
    $this->param['content'] .
    $booksTable;
  }
}