<?php

function myfn( $className )
{
    include "classes/$className.php";
}
spl_autoload_register('myfn');

$books[] = new Book('Книга 1', 'Автор 1');
$books[] = new Book('Книга 2', 'Автор 2');

$price = -100;
try{
    if($price < 0){
        throw new Error('Цена меньше нуля');
    }
    $books[] = new Book('Книга 3', 'Автор 3', '', $price);
}catch( Error $err ){
    echo $err->getMessage(), '<br />';
    echo $err->getFile(), '<br />';
    echo $err->getLine(), '<br />';
}


for($i = 0; $i < count($books); $i++){
    $books[$i]->title = 'Книга ' . $i;
    echo $books[$i]->get(), '<hr />';
}

