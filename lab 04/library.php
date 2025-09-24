<?php
require_once "database.php";

class Library extends Database {
    public $id;
    public $title;
    public $author;
    public $genre;
    public $publication_year;
    public $publisher;
    public $copies;

    public function addBook() {
        $sql = "INSERT INTO book (title, author, genre, publication_year, publisher, copies) 
                VALUES (:title, :author, :genre, :publication_year, :publisher, :copies)";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);

        return $query->execute();
    }

    public function viewBook($search = "", $genre = "") {
        $sql = "SELECT * FROM book 
                WHERE title LIKE CONCAT('%', :search, '%') 
                AND genre LIKE CONCAT('%', :genre, '%') 
                ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre);

        if ($query->execute()) {
            return $query->fetchAll();
        }
        return null;
    }

    public function isBookExist($title) {
        $sql = "SELECT COUNT(*) as total FROM book WHERE title = :title";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $title);
        $query->execute();
        $record = $query->fetch();
        return ($record["total"] > 0);
    }
}
