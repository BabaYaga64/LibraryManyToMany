<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library');

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Hemingway";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Fitzgerald";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Act
            $name = "Diaz";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $test_author->setId(2);

            //Assert
            $result = $test_author->getId();
            $this->assertEquals(2, $result);
        }

    }

 ?>
