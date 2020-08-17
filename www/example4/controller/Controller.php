<?php
include_once("model/Model.php");

class Controller {
	public $model;
	
	public function __construct()  
  {  
      $this->model = new Model();
  } 
	
	public function invoke()
	{
		if (!isset($_GET['book']))
		{
			// не запрашивается конкретная книга, покажем список всех доступных книг
			$books = $this->model->getBookList();
			include 'view/booklist.php';
		}
		else
		{
			// показываем запрошенную книну
			$book = $this->model->getBook($_GET['book']);
			include 'view/viewbook.php';
		}
	}
}

?>