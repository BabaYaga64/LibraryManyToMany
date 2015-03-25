<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
        }

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

        // save / getall / deleteall tests
        function test_save()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);

            //Act
            $test_book->save();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book], $result);
        }

        function test_getAll()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);
            $title2 = "Hamlet";
            $id2 = null;
            $duedate2 = '2017-01-01';

            $test_book2 = new Book($title2, $duedate2, $id2);

            //Act
            $test_book->save();
            $test_book2->save();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);
            $title2 = "Hamlet";
            $id2 = null;
            $duedate2 = '2017-01-01';
            $test_book2 = new Book($title2, $duedate2, $id2);
            $test_book->save();
            $test_book2->save();


            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_updateTitle()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);
            $test_book->save();
            $new_title = "Frankenstein";

            //Act
            $test_book->updateTitle($new_title);

            //Assert
            $this->assertEquals($test_book->getTitle(), $new_title);

        }

        function test_updateDueDate()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);
            $test_book->save();
            $new_date = '2054-12-12';

            //Act
            $test_book->updateDueDate($new_date);

            //Assert
            $this->assertEquals($test_book->getDueDate(), $new_date);

        }

        function test_deleteBook()
        {
            //Arrange
            $title = "Great Gatsby";
            $id = null;
            $duedate = '2016-01-01';
            $test_book = new Book($title, $duedate, $id);
            $test_book->save();

            $title2 = "Love in the Time of Cholera";
            $id2 = null;
            $duedate2 = '2016-01-01';
            $test_book2 = new Book($title2, $duedate2, $id2);
            $test_book2->save();

            //Act
            $test_book->deleteBook();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book2], $result);
        }

        //Finds a specific book from the two that are saved
        function test_find()
        {
            //Assert
            $title = "Brothers Karamazov";
            $id = 1;
            $title2 = "Stonehenge: A Study of Rocks";
            $id2 = 2;
            $duedate = '2016-01-01';
            $duedate2 = '2016-01-01';

            $test_book = new Book($title, $duedate, $id);
            $test_book->save();
            $test_book2 = new Book($title2, $duedate2, $id2);
            $test_book2->save();
            //Act
            $result = Book::find($test_book->getId());
            //Assert
            $this->assertEquals($test_book, $result);
        }


    }



?>
