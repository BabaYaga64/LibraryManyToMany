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


    }



?>
