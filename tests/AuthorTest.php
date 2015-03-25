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

        function test_save()
        {
            //Arrange
            $name = "Ann Lamott";
            $id = null;
            $test_author = new Author($name, $id);

            //Act
            $test_author->save();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Food";
            $id = null;
            $test_author = new Author($name, $id);
            $name2 = "Hamlet";
            $id2 = null;

            $test_author2 = new Author($name2, $id2);

            //Act
            $test_author->save();
            $test_author2->save();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_getBooks()
        {
            //Arrange
            $name = "Lovecraft";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $title = "Cthulhus Big Adventure";
            $id2 = 2;
            $genre = "romance";
            $test_book = new Book($title, $genre, $id2);
            $test_book->save();

            $title2 = "The Necromicon";
            $id3 = 3;
            $genre2 = "horror";
            $test_book2 = new Book($title2, $genre2, $id3);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Assert
            $result = $test_author->getBooks();
            $this->assertEquals([$test_book, $test_book2], $result);
        }




    }

 ?>
