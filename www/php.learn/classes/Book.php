<?php

class Book extends Goods
{
    public $author;
    public $description;

    public function __construct($title, $author, $description = '', $price = 0)
    {
        parent::__construct($title, $price);
        $this->description = $description;
        $this->price = $price;

        echo 'Создан экземпляр класса ' . __CLASS__ . '<hr />';
    }

    public function __destruct()
    {
        echo 'Удален экземпляр класса ' . __CLASS__ . '<hr />';
    }

    public function get($format = Goods::GOODS_HTML)
    {
        $method = 'get' . $format;
        return $this->$method();
    }

    public function getHTML()
    {
        return "<h3>{$this->title}</h3>
        <div>Автор: {$this->title}</div>
        <div>Описание: {$this->description}</div>
        <div>Цена: {$this->price}</div>";
    }
    
}