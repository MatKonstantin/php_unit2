<?php

class Book extends Goods implements IGoods
{
    public $author;
    public $description;
    public static $counter = 0;

    public function __construct($title, $author, $description = '', $price = 0)
    {
        parent::__construct($title, $price);
        self::$counter++;
        $this->description = $description;
        $this->price = $price;

        // echo 'Создан экземпляр класса ' . __CLASS__ . '<hr />';
    }

    public function __clone()
    {
        self::$counter++;
        echo 'Клонирован экземпляр класса ' . __CLASS__ . '<hr />';
    }

    public function __call($methodName, $arguments)
    {
        // echo $methodName . '<hr />';
        // echo '<pre>',print_r($arguments),'</pre>';
        if(method_exists($this, 'get'.$methodName)){
            $method = 'get'.$methodName;
            return $this->$method();
        }
    }

    public function __toString()
    {
        return $this->title;
    }

    public function __invoce()
    {
        return 'Вызвали как метод';
    }

    public function __destruct()
    {
        self::$counter--;
        // echo 'Удален экземпляр класса ' . __CLASS__ . '<hr />';
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

    public function getCSV()
    {
        return "CSV";
    }

    public function getJSON()
    {
        return "JSON";
    }
    public function getArray()
    {
        return "Array";
    }
    
}