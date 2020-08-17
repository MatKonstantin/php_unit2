<?php

class BookFabric 
{
    public static function get($title, $author, $description = '', $price = 0)
    {
        return new Book($title, $author, $description = '', $price = 0);
    }
}