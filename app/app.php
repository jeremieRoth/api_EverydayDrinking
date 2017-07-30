<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

use everydayDrinking\BDD\DAO\EstablishmentDAO;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());

$app['db.options'] = array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => '8889',
        'dbname' => 'everyday_drinking',
        'user' => 'root',
        'password' => 'root'
); 

// Register services.
$app['dao.establishment'] = function ($app) {
    return new EstablishmentDAO($app['db']);
};