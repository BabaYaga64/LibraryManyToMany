<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        function testGetTitle()
        {

            //Arrange
            $title = "Great Gatsby";
            $id = 1;
            $duedate = 2016;
            $test_book = new Book($title, $duedate, $id);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }


        function testGetId()
        {

            //Arrange
            $title = "Great Gatsby";
            $id = 1;
            $duedate = 2016;
            $test_book = new Book($title, $duedate, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testGetDueDate()
        {

            //Arrange
            $title = "Great Gatsby";
            $id = 1;
            $duedate = 2016;
            $test_book = new Book($title, $duedate, $id);

            //Act
            $result = $test_book->getDueDate();

            //Assert
            $this->assertEquals(2016, $result);
        }


        //We test the setId because we are drawing that out of the db later in the code

        function testsetId()
        {

            //Arrange
            $title = "Great Gatsby";
            $id = 1;
            $duedate = 2016;
            $test_book = new Book($title, $duedate, $id);

            //Act
            $test_book->setId(2);

            //Assert
            $result = $test_book->getId();
            $this->assertEquals(2, $result);
        }




    }



?>
