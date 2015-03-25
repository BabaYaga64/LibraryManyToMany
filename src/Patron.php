<?php

    class Patron
    {
        private $pname;
        private $id;

        function __construct($pname, $id)
        {
            $this->pname = $pname;
            $this->id = $id;
        }

        function getPname()
        {
            return $this->pname;
        }

        function getId()
        {
            return $this->id;
        }

        function setPname()
        {
            $this->pname = (string) $pname;
        }

        function setId()
        {
            $this->id = (int) $id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO patrons (name) VALUES ({$this->getName()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron) {
                $patron_id = $patron->getId();
                if ($patron_id == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = array();

            foreach($returned_patrons as $patron) {
                $pname = $patron['pname'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons *;");

        }

        //Deletes 1 patron
        function deletePatron()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }

    }


 ?>
