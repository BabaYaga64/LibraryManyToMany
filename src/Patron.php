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

        //Join copies to patrons
        function addCopy($copy)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id) VALUES ({$copy->getId()}, {$this->getId()});");

        }

        function getCopies()
        {

            $query = $GLOBALS['DB']->query("SELECT copies.* FROM patrons JOIN checkouts ON (patrons.id = checkouts.patron_id) JOIN copies ON (checkouts.copy_id = copies.id) WHERE patrons.id = {$this->getId()};");

            $copy_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $copies = array();
            foreach($copy_ids as $copy) {
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copy($id, $book_id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

    }


 ?>
