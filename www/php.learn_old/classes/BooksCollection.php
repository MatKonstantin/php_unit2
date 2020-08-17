<?php

class BooksCollection 
{
    protected $books = [];

    public function __construct(array $books)
    {
        $this->books = $books;
    }

    public function show()
    {
        echo "</p>книг всего: " . Book::$counter . '</p>';
        echo '</p>журналов всего: ' . Journal::$counter . '</p>';
        for($i = 0; $i < count($this->goods); $i++){
            echo $this->goods[$i]->get(), '<hr />';
        }
    }

    static public function insert( $mysqli, Book $book ){
        $query = "INSERT INTO books VALUES(NULL, ?, ?, ?, ?, ?)";

        $title = $book->title;
        $author = $book->author;
        $description = $book->description;
        $price = $book->price;
        $category = $book->category;

        if( $stmt = $mysqli->prepare( $query ) ){
            $stmt->bind_param("sssds", $title, $author, $description, $price, $category);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    static public function update($mysqli, $idbook, Book $book)
    {
        $query = "UPDATE books SET 
            idbook=$idbook,
            title=?,
            author=?,
            description=?,
            price=?,
            category=?
        ";

        $title = $book->title;
        $author = $book->author;
        $description = $book->description;
        $price = $book->price;
        $category = $book->category;

        if( $stmt = $mysqli->prepare( $query ) ){
            $stmt->bind_param("sssds", $title, $author, $description, $price, $category);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    static public function delete($mysqli, int $idbook)
    {
        $mysqli->query("DELETE FROM book WHERE idbook = " . $idbook);
    }

    static public function select( $mysqli, $idbook ){
    $query = "SELECT title, author, description, price, category FROM book WHERE idbook=".$idbook;
    if( $stmt = $mysqli->prepare( $query ) ){
        $stmt->execute();  
        $stmt->bind_result($title, $author, $description, $price, $category);
        $stmt->fetch();
        return new Book($title, $author, $description, $price, $category);
        }
        return false;  
    }
}