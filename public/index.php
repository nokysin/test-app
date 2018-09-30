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
use Src\App;

require_once __DIR__ . '/../Core/Autoloader.php';

$loader = new \Core\Autoloader();
$loader->register();
$loader->addNamespace('Core', 'Core');
$loader->addNamespace('Src', 'Src');


$router = new Router(new Request(), new Response());
$app = new App($router);

$app->start();

