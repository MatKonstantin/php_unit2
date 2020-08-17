<?php

function myfn( $className )
{
    include "classes/$className.php";
}
spl_autoload_register('myfn');

$books[] = new Book('Книга 1', 'Автор 1');
$books[] = new Book('Книга 2', 'Автор 2');

$books[] = new Journal('PHP', 'Расмус');
$books[] = BookFabric::get('Laravel', 'Мэтт Стаффер');

$books[] = clone $books[0];
$books[4]->title = 'qwerty';

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

$gc = new GoodsCollection($books);
$gc->show();

echo '<pre>',print_r($gc->HTML),'</pre>';

echo $books[4]->HTML(34,'foo');
