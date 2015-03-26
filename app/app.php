<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Copy.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();
    $app['debug'] = true;
    $DB = new PDO('pgsql:host=localhost;dbname=library');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //main page
    $app->get("/", function() use($app) {
        return $app['twig']->render('index.twig');
    });

    //show all books
    $app->get("/books", function() use($app) {
        return $app['twig']->render('books.twig', array('books' => Book::getAll()));
    });

    //add a book form goes through this
    $app->post("/books", function() use($app) {
        $new_book = new Book($_POST['title'], $_POST['genre']);
        $new_book->save();
        return $app['twig']->render('books.twig', array('books' => Book::getAll()));
    });

    //show one book & all info
    $app->get("/books/{id}", function($id) use($app) {
        $current_book = Book::find($id);
        return $app['twig']->render('a_book.twig', array('book' => $current_book));
    });

    //edit a single book
    $app->get("/books/{id}/edit", function($id) use($app) {
        $current_book = Book::find($id);
        return $app['twig']->render('book_edit.twig', array('book' => $current_book));
    });

    //edit form sent as a patch
    $app->patch("/books/{id}", function($id) use ($app) {
        $current_book = Book::find($id);
        $new_title = $_POST['title'];
        $current_book->update($new_title);
        return $app['twig']->render('a_book.twig', array('book' => $current_book));
        });

    //delete a specific book
    $app->delete("/books/{id}/delete", function($id) use ($app) {
        $current_book = Book::find($id);
        $current_book->delete();
        return $app['twig']->render('books.twig', array('books' => Book::getAll()));

    });

    //delete all books
        $app->post("/delete_books", function() use ($app) {
            Book::deleteAll();
            return $app['twig']->render('books.twig', array('books' => Book::getAll()));

        });

    return $app;

 ?>
