<?php
//https://www.sitepoint.com/the-mvc-pattern-and-php-1/ 
// https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2013/03/MVC-Process.png

include "config.php";

spl_autoload_register(function($className){
  include_once(__DIR__ . '/classes/' . $className . '.php' );
});

$controller = new Controller( $mysqli );

if (isset($_GET['action']) && !empty($_GET['action'])) {
  try{
    $view = $controller->{$_GET['action']}();
    echo $view->render();
  }catch(Error $er){
    echo "<h1>404</h1>";
    die;
  }  
}
