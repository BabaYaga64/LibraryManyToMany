<?php

    class Patron
    {
        private $pname;
        private $id;

        function __construct($pname, $id = null)
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

        function setPname($new_pname)
        {
            $this->new_pname = (string) $new_pname;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO patrons (p_name) VALUES ('{$this->getPname()}') RETURNING id;");
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
                $pname = $patron['p_name'];
                $id = $patron['id'];
                $new_patron = new Patron($pname, $id);
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
