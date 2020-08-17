<?php

ob_start();

include "config.php";
include "library.php";

function myfn( $className )
{
    include "classes/$className.php";
}
spl_autoload_register('myfn');

if( isset($_GET['del']) ){
  $del = (int) $_GET['del'];
  BooksCollection::delete($mysqli, $del);
}

if( isset($_GET['download']) ){
  
  $result = $mysqli->query("SELECT * FROM books");
  // $rows = $mysqli_fetch_all($result, MYSQLI_ASSOC);
  $rows = $result->fetch_all(MYSQLI_ASSOC);

  header('Content-Type: application/json');
  header('Content-Disposition: attachment; file="books.json"');
  echo json_encode($rows);
  die;
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $title = postParam('title');
  $author = postParam('author');
  $price = postParam('price', FILTER_SANITIZE_NUMBER_FLOAT);
  $description = postParam('description');
  $category = postParam('category', FILTER_SANITIZE_NUMBER_INT);
  $change = postParam('change', FILTER_SANITIZE_NUMBER_INT);

  if(
    BooksCollection::insert(
      $mysqli,
      new Book($title, $author, $description, $price, $category)
    )
  ){
    $_SESSION['flash'][] = 'Книга добавлена';
  } else {
    $_SESSION['flash'][] = 'Ошибка добавления книги';
  }

  header('Location: /formAddBook.php');
  die;
}

if(isset($_SESSION['flash']) && !empty($_SESSION['flash'])){
  foreach($_SESSION['flash'] as $flash){
    echo '<div class="alert">'.$flash.'</div>';
  }
  unset($_SESSION['flash']);
}

$change = (int) getParam('change');

?>


<div class="container">
<a href="?download=1" class="btn btn-success">Скачать список книг</a>
<h2>Добавление книги</h2>
      <form  method="POST">

      <?php if( $change ){ ?>
        <input type="hidden" name="change" value="<?= $change  ?>">
      <?php } ?>
      
        <div class="form-group">
		  <label for="title">Название книги</label>
          <input type="text" id="title" class="form-control" name="title" placeholder="title" required autofocus autocomplete="off" >
          
        </div>
        
        <div class="form-group">
		<label for="author">Имя автора</label>
          <input type="text" id="author" class="form-control" name="author" placeholder="author" required autofocus autocomplete="off" >
          
       </div>  

       <div class="form-group">
		<label for="price">Цена</label>
        <input type="text" id="price" class="form-control" name="price" placeholder="price" required autofocus autocomplete="off" >
        
      </div>    
      
      <div class="form-group">
		<label for="description">Описание книги</label>
        <textarea id="description" class="form-control" name="description" placeholder="description" required autofocus autocomplete="off" ></textarea>
        
      </div>  

    <div class="form-group">
		  <label for="category">Категория</label>
      <select  id="category" class="form-control" name="category" required >
        <option value='1'>классика
        <option value='2'>компьютерная
        <option value='3'>детектив
        <option value='4'>художественная
      </select>
        
    </div>  

    <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
  
  </form>
</div>

<div class="container">

<form  method="GET">
    <h2>Найти книгу</h2>
    <div class="form-group">
    <label for="title">Название книги</label>
        <input type="text" id="title" class="form-control" name="title" placeholder="title" required autofocus autocomplete="off" value="<?= getParam('title') ?>" >
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

if($title = getParam('title')){
  $query = "SELECT * FROM books WHERE title LIKE ?";
  if($stmt = $mysqli->prepare($query)) {
    $stitle = "%$title%";
    $stmt->bind_param("s", $stitle);
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
    <td><a class='btn btn-primary' href="?title=<?= $title ?>&del=<?= $idbook ?>">Удалить</a>
    <a class='btn btn-primary' href="?title=<?= $title ?>&change=<?= $idbook ?>">Изменить</a>
 <?php
    }
  $stmt->close();
  }}
 ?>
</table>
</div>

 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">