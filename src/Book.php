<?php

    class Book
    {
        private $title;
        private $genre;
        private $id;

        function __construct($title, $genre, $id)
        {
            $this->title = $title;
            $this->genre = $genre;
            $this->id = $id;
        }

    //GETTERS

        function getTitle()
        {
            return $this->title;
        }

        function getGenre()
        {
            return $this->genre;
        }

        function getId()
        {
            return $this->id;
        }

    //SETTERS

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function setGenre($new_genre)
        {
            $this->genre = (string) $new_genre;
        }

        function setId($new_id)
        {
            $this->id = (string) $new_id;
        }

    //DB FUNCTIONS

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title, genre) VALUES ('{$this->getTitle()}', '{$this->getGenre()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book) {
                $book_id = $book->getId();
                if ($book_id == $search_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();

            foreach($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $genre = $book['genre'];
                $new_book = new Book($title, $genre, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

    //DELETE FUNCTIONS

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books *;");
        }

        function deleteBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

    //UPDATE FUNCTIONS

        function updateTitle($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function updateGenre($new_genre)
        {
            $GLOBALS['DB']->exec("UPDATE books SET genre = '{$new_genre}' WHERE id = {$this->getId()};");
            $this->setGenre($new_genre);
        }

    //JOIN AUTHORS TO BOOKS

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
        }

        function getAuthors()
        {
            $query = $GLOBALS['DB']->query("SELECT authors.* FROM
                books JOIN books_authors ON (books.id = books_authors.book_id)
                      JOIN authors ON (books_authors.author_id = authors.id)
                      WHERE books.id = {$this->getId()};");
            $author_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach ($author_ids as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

    }



?>
