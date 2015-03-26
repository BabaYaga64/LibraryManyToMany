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
    //needs to create book, author, copies
    $app->post("/books", function() use($app) {
        $new_book = new Book($_POST['title'], $_POST['genre']);
        $new_book->save();
        $new_author = new Author($_POST['name']);
        $new_author->save();
        $new_book->addAuthor($new_author);
        $new_book_id = $new_book->getId();

        $copy = $_POST['copy'];
        for($i = 0; $i < $copy; $i++) {
            $new_copy = new Copy($new_book_id);
            $new_copy->save();
        }

        return $app['twig']->render('books.twig', array('books' => Book::getAll(), 'authors' => Author::getAll(), 'copies' => Copy::getAll()));
    });

    //show one book & all info (title, genre, author(s), copies)
    $app->get("/books/{id}", function($id) use($app) {
        $current_book = Book::find($id);
        $current_author = $current_book->getAuthors();

        $temp = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$id};");
        $result = $temp->fetchAll(PDO::FETCH_ASSOC);
        $count = count($result);

        return $app['twig']->render('a_book.twig', array('book' => $current_book, 'author' => $current_author[0], 'copy' => $count));
    });

    //edit a single book
    $app->get("/books/{id}/edit", function($id) use ($app) {
        $current_book = Book::find($id);
        return $app['twig']->render('book_edit.twig', array('book' => $current_book));
    });

    //edit form sent as a patch
    $app->patch("/books/{id}", function($id) use ($app) {
        $current_book = Book::find($id);
        $new_title = $_POST['title'];
        $current_book->updateTitle($new_title);

        // $new_genre = $_POST['genre'];
        // $current_book->updateGenre($new_genre);

        // to change the genre & not the title / vice versa, need if statements
        // if $_POST['genre'] = " " (unentered), use the original genre.
        // otherwise indexes are undefined are when the edit is posted.

        $current_author = $current_book->getAuthors();
        $temp = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$id};");
        $result = $temp->fetchAll(PDO::FETCH_ASSOC);
        $count = count($result);

        return $app['twig']->render('a_book.twig', array('book' => $current_book, 'author' => $current_author[0], 'copy' => $count));
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

    //show all authors
    $app->get("/authors", function() use($app) {
        return $app['twig']->render('authors.twig', array('authors' => Author::getAll()));
    });

    //add author (don't need to add books on this page)

    //edit author (can add books to author on this page)

    //edit form for author sent as patch

    //delete a specific author

    //delete all authors

    return $app;

 ?>
