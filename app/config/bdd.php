<?php 

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.option' => array(
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'everyday_drinking',
        'user' => 'root',
        'password' => 'root'
    ),

));