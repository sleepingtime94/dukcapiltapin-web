<?php

use Bramus\Router\Router;

$router = new Router();
$router->setNamespace('\App\Controllers');
$router->get('/', 'ViewController@home');

$router->get('/profil/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/pelayanan/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/publikasi/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/dokumen/([a-z_-]+)', 'ViewController@document');

$router->set404('ViewController@notFound');
$router->run();
