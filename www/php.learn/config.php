<?php

define('DBHOST',  'localhost');
define('DBLOGIN', 'root');
define('DBPASS',  'root');
define('DBNAME',  'eshop');


$dbLink = mysqli_connect(DBHOST, DBLOGIN, DBPASS, DBNAME);

if( mysqli_connect_errno() ){
  echo 'Проблема с подключением к базе! ' . mysqli_connect_error();  
  die;
}

/*
-- SQL-оператор создания таблицы
CREATE TABLE book (
  idbook INT PRIMARY KEY AUTO_INCREMENT,
  title  VARCHAR(100) NOT NULL, 
  author  VARCHAR(100) NOT NULL,
  description VARCHAR(2000) DEFAULT '',
  price DECIMAL(6,2),
  category ENUM('классика', 'компьютерная', 'детектив', 'художественная')
);

-- SQL-оператор вставки
INSERT INTO book VALUES(NULL, 'Первая книга', 'Автор1', '', 234.56, 'детектив');
INSERT INTO book VALUES(NULL, 'PHP8', 'пхпешник', '', 1000.56, 'компьютерная');

INSERT INTO book VALUES
 (NULL, 'Книга 1', 'Автор 1', '', 1000, 'детектив'),
 (NULL, 'Книга 2', 'Автор 2', '', 1200, 'детектив'),
 (NULL, 'Книга 3', 'Автор 3', '', 1300, 'компьютерная'),
 (NULL, 'Книга 4', 'Автор 4', '', 1400, 'компьютерная'),
 (NULL, 'Книга 5', 'Автор 5', '', 1500, 'компьютерная'),
 (NULL, 'Книга 6', 'Автор 6', '', 1600, 'классика');


-- SQL-оператор обновления для книги под номером 1
UPDATE book SET price = price * 1.1 WHERE idbook = 1;

-- SQL-оператор выборки
SELECT * FROM book;
SELECT author, title FROM book WHERE idbook = 1;

-- SQL-оператор удаления книги под номером 1
DELETE FROM book WHERE idbook = 1;
*/

//устанавливаем кодировку соединения
mysqli_query($dbLink, 'SET NAMES utf8');