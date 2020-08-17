<?php
//https://www.sitepoint.com/the-mvc-pattern-and-php-1/ 
// https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2013/03/MVC-Process.png

spl_autoload_register(function($className){
  include_once(__DIR__ . '/classes/' . $className . '.php' );
});

$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);

if (isset($_GET['action']) && !empty($_GET['action'])) {
  try{
    $controller->{$_GET['action']}();
  }catch(Error $er){
    echo "<h1>404</h1>";
    die;
  }  
}
echo $view->render();