<?php

    Class Copy
    {
        private $id;
        private $book_id;

        function __construct($book_id, $id = null)
        {
            $this->book_id = $book_id;
            $this->id = $id;
        }

//GETTERS
        function getId()
        {
            return $this->id;
        }

        function getBook_Id()
        {
            return $this->book_id;
        }

//SETTERS
        function setId($new_id)

        {
            $this->id = (int) $new_id;
        }

        function setBook_Id($new_book_id)

        {
            $this->new_book_id = (int) $new_book_id;
        }

//DB FUNCTIONS
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO copies (book_id) VALUES ({$this->getBook_Id()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function find($search_id)
        {
            $found_copy = null;
            $copies = Book::getAll();
            foreach($copies as $copy) {
                $copy_id = $copy->getId();
                if ($copy_id == $search_id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = array();

            foreach($returned_copies as $copy) {
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copy($book_id, $id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

//DELETE FUNCTIONS
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies *;");
        }
        //Deletes 1 copy
        function deleteCopy()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
        }

        //Deletes ALL copies of one book
        function deleteBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE book_id = {$this->getId()};");

        }

//JOIN PATRONS TO COPIES
        function addPatron($patron)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id) VALUES ({$this->getId()}, {$patron->getId()});");
        }

        function getPatrons()
        {
            $query = $GLOBALS['DB']->query("SELECT patrons.* FROM
                    copies JOIN checkouts ON (copies.id = checkouts.copy_id)
                           JOIN patrons ON (checkouts.patron_id = patrons.id)
                           WHERE copies.id = {$this->getId()};");

            $patron_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $patrons = array();
            foreach($patron_ids as $patron) {
                $pname = $patron['p_name'];
                $id = $patron['id'];
                $new_patron = new Patron($pname, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }


    }

 ?>
