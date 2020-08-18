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
  public function addtobasket(){
    if(!empty($_GET['add'])){
      $add = (int) $_GET['add'];
      $_SESSION['basket'][$add]++;
    }
    self::redirect('/index');
  }
  public function clearbasket(){
    unset($_SESSION['basket']);
    self::redirect('/basket/');
  }
  public function saveorder(){
    $idOrder = uniqid();
    /* CREATE TABLE `items_order` (
      iditem INT PRIMARY KEY AUTO_INCREMENT,
      idorder CHAR(13) NOT NULL,
      parent_idbook INT,
      qty TINYINT,
      INDEX par_ind (parent_idbook), FOREIGN KEY(parent_idbook) REFERENCES books(idbook)
    ) 
    */
    if( Order::save($this->mysqli, $idOrder, $_SESSION['basket']) ){
      $_SESSION['flash'][] = 'Заказ оформлен';
      unset($_SESSION['basket']);
    } else {
      $_SESSION['flash'][] = 'Проблема с оформлением';
    }

    self::redirect('/index/');
  }
  static public function redirect($url){
    header("Location: $url");
    die;
  }
}