<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";
    require_once "src/Patron.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Copy::deleteAll();
        }

        function test_Pname()
        {
            //Arrange
            $pname = "McDingle";
            $id = 1;
            $test_patron = new Patron($pname, $id);

            //Act
            //Whatever we're testing goes here in the method
            $result = $test_patron->getPname();

            //Assert
            $this->assertEquals($pname, $result);

        }

        function test_getId()
        {
            //Arrange
            $pname = "Delilah";
            $id = 1;
            $test_patron = new Patron($pname, $id);

            //Act
            $result = $test_patron->getId();

            //Assert
            $this->assertEquals(1, $result);

        }

        function test_setId()
        {

            //Arrange
            $pname = "Delilah";
            $id = 1;
            $test_patron = new Patron($pname, $id);

            //Act
            $test_patron->setId(2);

            //Assert
            $result = $test_patron->getId();
            $this->assertEquals(2, $result);

        }

        function test_save()
        {
            //Arrange
            $pname = "Delilah";
            $id = 1;
            $test_patron = new Patron($pname, $id);

            //Act
            $test_patron->save();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron, $result[0]);


        }

        function test_getAll()
        {
            //Arrange
            $pname = "Marcy";
            $id = 1;
            $test_patron = new Patron($pname, $id);
            $test_patron->save();

            $pname2 = "Ralph";
            $id2 = 2;
            $test_patron2 = new Patron($pname2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);

        }


        function test_deleteAll()
        {

        //Arrange
        $pname = "Lucky";
        $id = 1;
        $test_patron = new Patron($pname, $id);
        $test_patron->save();

        $pname2 = "Priscilla";
        $id2 = 2;
        $test_patron2 = new Patron($pname2, $id2);
        $test_patron2->save();

        //Act
        Patron::deleteAll();

        //Assert
        $result = Patron::getAll();
        $this->assertEquals([], $result);

        }
    }
?>
