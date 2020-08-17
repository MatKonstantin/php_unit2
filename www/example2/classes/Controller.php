<?php

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