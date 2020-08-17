<?php

class BookFabric {

  public static function get($title, $author, $description = '', $price = 0){
    /* вот тут какая-то интересная логика */
    return new Book($title, $author, $description, $price);
  }

}