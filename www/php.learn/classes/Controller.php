<?php

class Controller
{

  protected $mysqli;

  public function __construct($mysqli){
    $this->mysqli = $mysqli;
  }
  public function index(){
    $content = "<h1>Каталог</h1>";

    $books = BookCollection::selectAll( $this->mysqli );

    return new View(['content' => $content, 'books' => $books]);
  }
  public function about(){
    $content = "<h1>О нас</h1>";
    return new View(['content' => $content]);
  }
  public function basket(){
    $content = "<h1>Корзина</h1>";
    return new View(['content' => $content]);
  }
  public function login(){
    $content = "<h1>Войти</h1>";
    return new View(['content' => $content]);
  }
}