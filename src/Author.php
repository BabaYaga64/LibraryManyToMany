<?php

    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

    //GETTERS
        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

    //SETTERS
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

    //DB FUNCTIONS
        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_id = $author->getId();
                if ($author_id == $search_id) {
                    $found_author = $author;
                }
            } return $found_author;
        }

        static function findName($search_name)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author) {
                $author_name = $author->getName();
                if ($author_name == $search_name) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO authors (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = array();

            foreach($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

    //UPDATE
        function updateAuthor($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

    //DELETE
        function deleteAuthor()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors *;");
        }

    //JOIN BOOKS TO AUTHORS
        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$book->getId()}, {$this->getId()});");
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT books.* FROM
                authors JOIN books_authors ON (authors.id = books_authors.author_id)
                        JOIN books ON (books_authors.book_id = books.id)
                        WHERE authors.id = {$this->getId()};");
            $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $books = array();
            foreach ($book_ids as $book) {
                $title = $book['title'];
                $genre = $book['genre'];
                $id = $book['id'];
                $new_book = new Book($title, $genre, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

    }




 ?>
