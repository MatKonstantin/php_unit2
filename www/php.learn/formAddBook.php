<?php

ob_start();

include "config.php";
include "library.php";

if( isset($_GET['download']) ){
  
  $result = mysqli_query($dbLink, "SELECT * FROM books");
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

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

  $query = "INSERT INTO books VALUES(NULL, ?, ?, ?, ?, ?)";
  if($stmt = mysqli_prepare($dbLink, $query)) {
    mysqli_stmt_bind_param($stmt, "sssds", $title, $author, $description, $price, $category);
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['flash'][] = 'Книга добавлена';
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

?>


<div class="container">
<a href="?download=1" class="btn btn-success">Скачать список книг</a>
<h2>Добавление книги</h2>
      <form  method="POST">
      
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
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">