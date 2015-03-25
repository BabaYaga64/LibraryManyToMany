<?php

    class Book
    {
        private $title;
        private $duedate;
        private $id;

        function __construct($title, $duedate, $id)
        {
            $this->title = $title;
            $this->duedate = $duedate;
            $this->id = $id;
        }

    //GETTERS

        function getTitle()
        {
            return $this->title;
        }

        function getDueDate()
        {
            return $this->duedate;
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

        function setDueDate($new_duedate)
        {
            $this->duedate = (string) $new_duedate;
        }

        function setId($new_id)
        {
            $this->id = (string) $new_id;
        }

    //DB FUNCTIONS

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title, duedate) VALUES ('{$this->getTitle()}', '{$this->getDueDate()}') RETURNING id;");
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
                $duedate = $book['duedate'];
                $new_book = new Book($title, $duedate, $id);
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

        function updateDueDate($new_date)
        {
            $GLOBALS['DB']->exec("UPDATE books SET duedate = '{$new_date}' WHERE id = {$this->getId()};");
            $this->setDueDate($new_date);
        }

    }



?>
