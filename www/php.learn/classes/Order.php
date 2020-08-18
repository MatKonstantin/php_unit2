<?php

class Order {
    static public function save($mysqli, $idOrder, $basket): bool
    {
        /*INSERT INTO items_order(idorder, parent_idbook, qty)
        VALUES ('qwerty', 2, 1);*/
        $sql = 'INSERT INTO items_order(idorder, parent_idbook, qty) VALUES';
        foreach( $basket as $idbook => $qty ){
            $values[] = "('$idOrder', $idbook, $qty )";
        }
        $sql .= implode(',', $values);
        $mysqli->query($sql);

        if($mysqli->errno){
            return false;
        }
        return true;
    }
}