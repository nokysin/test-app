<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.09.2018
 * Time: 20:15
 */

namespace Src;

use Core\Http\Request\IRequest;
use Core\Http\Request\Request;
use Core\Http\Response\IResponse;
use Core\Router\IRouter;

/**
 * Class App
 * @package Restfull\App
 */
class App
{
    /**
     * @var \Core\Router\Router
     */
    protected $router;

    protected $request;

    protected $response;

    /**
     * App constructor.
     *
     * @param \Core\Router\IRouter          $router
     * @param \Core\Http\Request\IRequest   $request
     * @param \Core\Http\Response\IResponse $response
     */
    public function __construct(IRouter $router)
    {
        $this->router   = $router;
        $this->request  = $router->getRequest();
        $this->response = $router->getResponse();

        $this->setRoutes();
    }

    public function start()
    {
        $this->router->resolve();
    }

    /**
     * @return void
     */
    protected function setRoutes()
    {
        $this->router->addRoute('/costs', [
            'controller' => 'Cost',
            'action'     => 'list',
            'method'     => Request::HTTP_GET,
            'security'   => true,
        ]);
        $this->router->addRoute('/cost/{id}', [
            'controller'  => 'Cost',
            'action'      => 'view',
            'method'      => Request::HTTP_GET,
            'security'    => true,
            'constraints' => ['id' => '\d+$'],
        ]);

        $this->router->addRoute('/auth/token', [
            'controller' => 'Auth',
            'action'     => 'token',
            'method'     => Request::HTTP_POST,
            'security'   => false,
        ]);

    }
}