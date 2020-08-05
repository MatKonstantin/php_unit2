<?php
// declare(strict_types=1);

/**
 * renderCategories() функция отрисовки категорий книг
 * @cat array - обычный массив строк-категорий
 * @return string - набор ссылок с категориями
 */
function renderCategories( Array $cat = ['научпоп'] ): string{
  $result = '';
  $i = 0;
  while( $i < count($cat) ){
    $j = $i + 1;
    $result = $result . "<a class=\"dropdown-item\" href=\"?category={$j}\">" . $cat[$i] . "</a>";
    $i++;
  }
  return $result;  
}

/**
 * renderPublisher() функция отрисовки категорий издательств
 * @pub array - обычный массив строк-названий издательств
 * @return string - набор строку для отрисовки
 */
function renderPublisher(Array $pub = []): string{
  $result = '';
  
  for($i = 0; $i < count($pub); ++$i ){
    $result .= <<<LI
  <li class="list-group-item">
    <input type="checkbox"  id="exampleCheck{$i}" name="publisher[]" value="{$i}">
    <label class="form-check-label" for="exampleCheck{$i}"> {$pub[$i]} </label>
  </li>
LI;
  }
  return $result;  
}

function renderMenu( $menu ){

}

/**
 * saveOrder() функция сохранения заказа в файл
 * @firstName string - имя заказчика
 * @lastName string - фамилия заказчика
 * @email string - email заказчика
 * @address string - адрес заказчика
 * @return boolean - результат
 */
function saveOrder( $firstName, $lastName, $email, $address ){
  $time = time(); 
  $idorder = uniqid();
  $order = "$idorder|$time|$firstName|$lastName|$email|$address\n";
  if( file_put_contents(ORDERS, $order, FILE_APPEND) ){
    return true;
  }
  return false;
}

//Функция для получения книг из базы
function getBookByCategories( $dbLink, $category = '' ){
  $books = [];
  
  $query = 'SELECT * FROM book';

  if( $category ){
    $query .= " WHERE category='$category'";
  }

  $result = mysqli_query($dbLink, $query);

  if( mysqli_errno($dbLink) ){
    //echo mysqli_error($dbLink);
    return false;
  }

  $books = mysqli_fetch_all($result, MYSQLI_ASSOC);

  return $books;
}

function calcAmount( $delta = 0){
  static $summa = 0;
  $summa += $delta;
  return $summa;
}

function getParam( $param ): ?string {
  if( $_GET[$param] ){
    return str_replace('|', '', trim(strip_tags($_GET[$param])));
  } else {
    return null;
  }
} 

function postParam( $param ): ?string {
  if( $_POST[$param] ){
    return str_replace('|', '', trim(strip_tags($_POST[$param])));
  } else {
    return null;
  }
} 

//Функция возвращает массив книг, которые есть в корзине. С ключами - номерами книг.
function getBooksByBasket(){
  global $books;
  $booksBasket = [];
  foreach( $books as $book ){
    if( array_key_exists($book['idbook'], $_SESSION['basket']) ){
      $booksBasket[$book['idbook']] = $book;
    }
  }
  return $booksBasket;
}