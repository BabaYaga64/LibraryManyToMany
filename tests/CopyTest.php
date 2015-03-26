<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Patron.php";
    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copy::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $title = "Great Gatsby";
            $genre = "Adventure";
            $id = null;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $book_id = $test_book->getId();
            $test_copy = new Copy($id, $book_id);
            $test_copy->save();

            //Act
            $result = $test_copy->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        // function test_save()
        // {
        //     //Arrange
        //     $title = "Hamlet";
        //     $genre = "Drama";
        //     $id = null;
        //     $test_book = new Book($title, $genre, $id);
        //     $test_book->save();
        //
        //     $book_id = $test_book->getId();
        //     $test_copy = new Copy($book_id, $id2);
        //
        //
        //     //Act
        //     $test_copy->save();
        //     $result = Copy::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_copy], $result);
        // }

        // function test_getAll()
        // {
        //     //Arrange
        //     $book_id = 1;
        //     $id = null;
        //     $test_copy = new Copy($book_id, $id);
        //     $book_id2 = 2;
        //     $id2 = null;
        //     $test_copy2 = new Copy($book_id2, $id2);
        //
        //     //Act
        //     $test_copy->save();
        //     $test_copy2->save();
        //     $result = Copy::getAll();
        //
        //     //Assert
        //     $this->assertEquals([$test_copy, $test_copy2], $result);
        // }
        //
        // function test_deleteAll()
        // {
        //     //Arrange
        //     $book_id = "Great Gatsby";
        //     $id = null;
        //
        //     $test_copy = new Copy($book_id, $id);
        //     $book_id2 = "Hamlet";
        //     $id2 = null;
        //
        //     $test_copy2 = new Copy($book_id2, $id2);
        //     $test_copy->save();
        //     $test_copy2->save();
        //
        //     //Act
        //     Copy::deleteAll();
        //     $result = Copy::getAll();
        //
        //     //Assert
        //     $this->assertEquals([], $result);
        // }

    }

 ?>
