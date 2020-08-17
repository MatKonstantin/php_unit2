<?php
ob_start(); //старт буферизации вывода

session_start();
include "config.php";
include "library.php";

function myfn( $className ){
  include "classes/$className.php";
}
spl_autoload_register('myfn');

if( isset($_GET['del']) ){
  $del = (int) $_GET['del'];
  //$mysqli->query("DELETE FROM book WHERE idbook = " . $del);
  BookCollection::delete($mysqli, $del);
}

if( isset($_GET['download']) ){
  // $result = mysqli_query($dbLink, "SELECT * FROM book");
  // $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $result = $mysqli->query("SELECT * FROM book");
  $rows = $result->fetch_all(MYSQLI_ASSOC);

  header('Content-Type: application/json');
  header('Content-Disposition: attachment; filename="books.json"');
  echo json_encode($rows);
  die;
}

if(  $_SERVER['REQUEST_METHOD'] == 'POST' && postParam('change')){
  $title = postParam('title');
  $author = postParam('author');
  $description = postParam('description');
  $price = (double) postParam('price'); 
  $category = postParam('category', FILTER_SANITIZE_NUMBER_INT);
  $change = postParam('change', FILTER_SANITIZE_NUMBER_INT);

  if(
    BookCollection::update(
      $mysqli,
      $change,
      new Book($title, $author, $description, $price, $category)
    ) 
  ){
    $_SESSION['flash'][] = 'Книга <strong>обновлена</strong>!';
  } else {
    $_SESSION['flash'][] = 'Проблема с <strong>обновлением</strong> книги';
  }
  header('Location: /formAddBook.php');
  die;
}


if(  $_SERVER['REQUEST_METHOD'] == 'POST'){
  $title = postParam('title');
  $author = postParam('author');
  $description = postParam('description');
  $price = postParam('price', FILTER_SANITIZE_NUMBER_FLOAT); 
  $category = postParam('category', FILTER_SANITIZE_NUMBER_INT);
  
  // $query = "INSERT INTO book VALUES(NULL, ?, ?, ?, ?, ?)";
  // if( $stmt = $mysqli->prepare( $query ) ){
  //   print_r($stmt);
  //   $stmt->bind_param("sssds", $title, $author, $description, $price, $category);
  //   $stmt->execute();
  //   $stmt->close();
  //   $_SESSION['flash'][] = 'Книга добавлена';
  // } else {
  //   $_SESSION['flash'][] = 'Проблема с добавление книги';
  // }
  

  if(
    BookCollection::insert(
      $mysqli,
      new Book($title, $author, $description, $price, $category)
    ) 
  ){
    $_SESSION['flash'][] = 'Книга добавлена';
  } else {
    $_SESSION['flash'][] = 'Проблема с добавление книги';
  }


  header('Location: /formAddBook.php');
  die;
}

if( is_array($_SESSION['flash']) && count($_SESSION['flash']) ){
  foreach($_SESSION['flash'] as $message){
    echo $message, '<hr/>';
  }
  unset($_SESSION['flash'] );
}

$change = (int) getParam('change');
if( $change ){
  $changeBook = BookCollection::select($mysqli, $change);
}

?><div class="container">
<a href="?download" class="btn btn-lg btn-primary " >Скачать все книги</a>
<h2>Добавление книги</h2>
      <form  method="POST">
      
      <?php if( $change ){ ?>
        <input type="hidden" name="change" value="<?= $change  ?>">
      <?php } ?>

        <div class="form-group">
		  <label for="title">Название книги</label>
          <input type="text" value="<?= $change ? $changeBook->title : ''  ?>" id="title" class="form-control" name="title" placeholder="title" required autofocus autocomplete="off" >
          
        </div>
        
        <div class="form-group">
		<label for="author">Имя автора</label>
          <input type="text" value="<?= $change ? $changeBook->author : ''  ?>" id="author" class="form-control" name="author" placeholder="author" required autofocus autocomplete="off" >
          
       </div>  

       <div class="form-group">
		<label for="price">Цена</label>
        <input type="text" value="<?= $change ? $changeBook->price : ''  ?>" id="price" class="form-control" name="price" placeholder="price" required autofocus autocomplete="off" >
        
      </div>    
      
      <div class="form-group">
		<label for="description">Описание книги</label>
        <textarea id="description" value="<?= $change ? $changeBook->description : ''  ?>" class="form-control" name="description" placeholder="description" required autofocus autocomplete="off" ></textarea>
        
      </div>  

      <div class="form-group">
		<label for="category">Категория</label>
        <select  id="category" class="form-control" name="category" required >
          <option >классика
          <option >компьютерная
          <option >детектив
          <option >художественная
        </select>
        
      </div>  
  
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= $change ? 'Обновить' : 'Добавить'?></button>
      
      </form>
      </div>
<div class="container">

<form  method="GET">
    <h2>Найти книгу</h2>
    <div class="form-group">
    <label for="title">Название книги</label>
        <input type="text" 
        value="<?= getParam('title') ?? '' ?>"
        id="title" class="form-control" name="title" placeholder="title" required autofocus autocomplete="off" >
    </div>
</form>
<table class="table table-border">
  <tr>
    <th>№п/п</th>
    <th>Название</th>
    <th>Автор</th>
    <th>Описание</th>
    <th>Цена</th>
    <th>Категория</th>
    <th>Операция</th>
  </tr>
<?php

if( $title = getParam('title')){
  $query = "SELECT * FROM book WHERE title LIKE ?";
  if( $stmt = $mysqli->prepare( $query ) ){
    $stmt->bind_param("s", $title = "%$title%");
    $stmt->execute();

    $stmt->bind_result($idbook, $title, $author, $description, $price, $category);

    /* Выбрать значения */
    while ($stmt->fetch()) {
?>
   <tr>
    <td><?= ++$i ?>
    <td><?= $title ?>
    <td><?= $author ?>
    <td><?= $description ?>
    <td><?= $price ?>
    <td><?= $category ?>
    <td>
     <a class='btn btn-primary' href="?title=<?= getParam('title') ?>&del=<?= $idbook ?>">Удалить</a>
     <a class='btn btn-primary' href="?title=<?= getParam('title') ?>&change=<?= $idbook ?>">Изменить</a>
<?php
    }

    $stmt->close();
  }
}

?>
</table>
</div>

 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">