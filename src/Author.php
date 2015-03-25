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

        }

        static function getAll()
        {

        }

        static function deleteAll()
        {

        }

    }

 ?>
