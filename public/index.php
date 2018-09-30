<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 26.09.2018
 * Time: 18:04
 */


use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Router\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Core/Autoloader.php';


$loader = new \Core\Autoloader();
$loader->register();
$loader->addNamespace('Core', 'Core');
$loader->addNamespace('Src', 'Src');


$request  = new Request();
$response = new Response();
$router = new Router($request, $response);


$router->addRoute('/costs', [
    'controller' => 'Cost',
    'action'     => 'list',
    'method'     => Request::HTTP_GET,
    'security'   => true,
]);
$router->addRoute('/cost/{id}', [
    'controller'  => 'Cost',
    'action'      => 'view',
    'method'      => Request::HTTP_GET,
    'security'    => true,
    'constraints' => ['id' => '\d+$'],
]);

$router->addRoute('/auth/token', [
    'controller' => 'Auth',
    'action'     => 'token',
    'method'     => Request::HTTP_POST,
    'security'   => false,
]);


$router->resolve();
