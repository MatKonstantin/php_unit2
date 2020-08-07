<?php

class GoodsCollection 
{
    protected $goods = [];

    public function __construct(array $goods)
    {
        $this->goods = $goods;
    }

    public function show()
    {
        echo "</p>книг всего: " . Book::$counter . '</p>';
        echo '</p>журналов всего: ' . Journal::$counter . '</p>';
        for($i = 0; $i < count($this->goods); $i++){
            echo $this->goods[$i]->get(), '<hr />';
        }
    }

    public function __get($propertyName)
    {
        $fn = function($item) use ($propertyName){
            return $item instanceof $propertyName ? 1 : 0;
        };
        return array_filter($this->goods, $fn);
    }
}