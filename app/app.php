<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

use everydayDrinking\BDD\DAO\EstablishmentDAO;
use everydayDrinking\BDD\DAO\CommentDAO;
use everydayDrinking\BDD\DAO\DrinkDAO;
use everydayDrinking\BDD\DAO\LocationDAO;
use everydayDrinking\BDD\DAO\UserDAO;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());

$app['db.options'] = array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => '3306',
        'dbname' => 'everyday_drinking',
        'user' => 'root',
        'password' => 'root'
); 

// Register services.
$app['dao.establishment'] = function ($app) {
    return new EstablishmentDAO($app['db']);
};

$app['dao.comment'] = function ($app) {
    return new CommentDAO($app['db']);
};

$app['dao.drink'] = function ($app) {
    return new DrinkDAO($app['db']);
};

$app['dao.location'] = function ($app) {
    return new LocationDAO($app['db']);
};

$app['dao.user'] = function ($app) {
    return new UserDAO($app['db']);
};

$app['dao.event'] = function ($app) {
    return new EventDAO($app['db']);
};


