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

    $app->get("/", function() use($app) {
        return $app['twig']->render('index.twig');
    });

    


    return $app;

 ?>
