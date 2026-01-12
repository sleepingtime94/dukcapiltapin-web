<?php

use Bramus\Router\Router;

$router = new Router();
$router->setNamespace('\App\Controllers');
$router->get('/', 'ViewController@home');
$router->get('/profil/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/pelayanan/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/publikasi/([a-z0-9_-]+)', 'ViewController@preview');
$router->get('/dokumen/([a-z_-]+)', 'ViewController@document');

$router->before('POST', '/upload', 'AuthController@limitAccess');
$router->post('/upload', 'UploadController@uploadFile');

$router->before('GET', '/login', 'AuthController@logged');
$router->get('/login', 'ViewController@login');

$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->before('GET', '/dashboard', 'AuthController@authenticate');
$router->get('/dashboard', 'ViewController@dashboard');


$router->set404('ViewController@notFound');
$router->run();
