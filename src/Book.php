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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books *;");
        }

    }



?>
