<?php

class Model 
{
  public $content;
  public function __construct(){
    $this->content = '<h1>Hello, world!</h1>';
  }
}
class View
{
  private $model;
  private $controller;
  public function __construct(Controller $controller, Model $model){
    $this->controller = $controller;
    $this->model = $model;
  }
  public function render(){
    return  
      '<a href="mvc.php?action=index">Index</a> ' .
      '<a href="mvc.php?action=about">About</a> ' .
    $this->model->content;
  }
}
class Controller
{
  private $model;
  
  public function __construct(Model $model){
    $this->model = $model;
  }
  public function index(){
    return $this->model->content;
  }
  public function about(){
   return $this->model->content = "<h1>About</h1>";    
  }
}

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