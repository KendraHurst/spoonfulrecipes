<?php

chdir(__DIR__);
session_start();

$f3 = Base::instance();

$f3->config('php.ini');
$f3->config('config.ini');
$f3->config('routes.ini');

$f3->set('mysql', new \DB\SQL('mysql:host=localhost;port=3306;dbname=' . $f3->get('mysql.database'),$f3->get('mysql.username'),$f3->get('mysql.password')));

$f3->run();
