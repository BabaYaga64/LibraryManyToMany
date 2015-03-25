<?php

    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id)
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
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO authors (name) VALUES '{$this->getName()}';");
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
            $GLOBALS['DB']->exec("DELETE FROM authors *;")
        }

    }



 ?>
