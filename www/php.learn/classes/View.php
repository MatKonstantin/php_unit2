<?php

class View
{

  public $param = [];
  public function __construct( $param ){
    $this->param = $param;
  }
  public function render(){
    $flash = '';

    if(isset($_SESSION['flash'])){
      foreach($_SESSION['flash'] as $message){
        $flash .= "<div>$message</div>";
      }
      unset($_SESSION['flash']);
    }

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
        $booksTable .= "<td><a href='/addtobasket/?add=$idbook'>В корзину</a>";
      }
      $booksTable .= "</table>";
    }    

    $counter = 0;
    if( is_array($_SESSION['basket']) ) {
      foreach( $_SESSION['basket'] as $idbook => $quantity ){
        $counter += $quantity;
      }
    }

    return  
      '<nav>' .
      '<a href="/index/">Каталог</a> ' .
      "<a href='/basket/'>Корзина ({$counter})</a> " .
      '<a href="/about/">О нас</a> ' .
      '<a href="/login/">Войти</a> ' .
      '</nav>' .
    $this->param['content'] .
    $booksTable;
  }
}