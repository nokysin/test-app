<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.09.2018
 * Time: 12:07
 */

namespace Core\Router;

use Core\Http\Request\IRequest;
use Core\Http\Response\IResponse;
use Core\Http\Response\Response;
use Core\Security\Security;

/**
 * Class Router
 */
class Router implements IRouter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor.
     *
     * @param \IRequest $request
     *
     * @return void
     */
    public function __construct(IRequest $request, IResponse $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @param string  $name
     * @param string  $controller
     * @param string  $action
     * @param string  $method
     * @param boolean $security
     *
     * @return void
     */
    public function addRoute(string $route, array $params)
    {
        $this->routes[$route] = $params;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     *
     * @param string $route
     *
     * @return string
     */
    protected function formatRoute($route): string
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }

        return $result;
    }

    /**
     * @return void
     */
    protected function methodUnauthorized()
    {
        $statusCode = Response::HTTP_UNAUTHORIZED;

        $this->sendErrorResponse($statusCode);
    }

    /**
     * @return void
     */
    protected function methodNotAllowed()
    {
        $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;

        $this->sendErrorResponse($statusCode);
    }

    /**
     * @return void
     */
    protected function methodNotFound()
    {
        $statusCode = Response::HTTP_NOT_FOUND;

        $this->sendErrorResponse($statusCode);
    }

    /**
     * @param \Core\Router\integer $statusCode
     */
    protected function sendErrorResponse(int $statusCode)
    {

        $this->response->setStatusCode($statusCode);
        $this->response->addHeaders(['Content-Type' => 'application/json']);
        $this->response->setContent(json_encode([
            'code'    => $statusCode,
            'message' => Response::$statusTexts[$statusCode],
        ]));
        $this->response->send();
    }

    /**
     * @param string $route
     * @param string $url
     *
     * @return array
     */
    protected function parseParams(string $routeOriginal, string $url): array
    {
        $url = parse_url($url)['path'];

        $route = explode('/', $routeOriginal);
        $url   = explode('/', $url);

        $params = [];
        foreach ($route as $index => $item) {
            if (strpos($item, '{') === 0 && array_key_exists($index, $url)) {
                $key          = str_replace(['{', '}'], ['', ''], $item);
                $params[$key] = $url[$index];
            }
        }

        return array_merge($params, $this->request->getBody(), $_GET);
    }

    /**
     * @param array  $routes
     * @param string $url
     */
    protected function getOriginalRoute(string $urlOriginal)
    {
        $urlOriginal = parse_url($urlOriginal)['path'];

        foreach ($this->getRoutes() as $routeName => $routeParams) {

            if ($urlOriginal === $routeName) {
                return $routeName;
            }

            if ($this->checkUrlByRegexp($routeName, $urlOriginal)) {
                return $routeName;
            }
        }

        return false;
    }

    protected function checkUrlByRegexp(string $route, string $url)
    {
        $paramPosStart = strpos($route, '{');
        $paramPosEnd   = strpos($route, '}');

        $route = substr_replace($route, '[\w+]', $paramPosStart, $paramPosEnd - $paramPosStart + 1);
        $route = str_replace('/', '\/', $route);
        $route = '/' . $route . '/';

        preg_match($route, $url, $matches);

        return !empty($matches) ? true : false;
    }

    /**
     * @param string $routeName
     * @param array  $params
     *
     * @return bool
     */
    protected function checkRouteConstraints(string $routeName, array $params)
    {
        $routeConstraints = $this->getRouteOption($routeName, 'constraints');

        if (false === $routeConstraints) {
            return true;
        }

        $verify = 0;
        if (!empty($routeConstraints)) {
            foreach ($routeConstraints as $paramName => $routeConstraint) {

                if (array_key_exists($paramName, $params)) {
                    $value = $params[$paramName];

                    preg_match("/{$routeConstraint}/", $value, $match);

                    if (count($match) !== 0) {
                        $verify++;
                    }

                }
            }
        }

        return $verify === count($routeConstraints);
    }

    /**
     * Resolves a route
     *
     * @return void
     */
    public function resolve()
    {
        $method         = $this->request->requestMethod;
        $formattedRoute = $this->formatRoute($this->request->requestUri);

        // search original route
        $routeOriginal = $this->getOriginalRoute($formattedRoute);


        if (false !== $routeOriginal && array_key_exists($routeOriginal, $this->getRoutes())) {

            $route = $this->getRouteByName($routeOriginal);

            list($controller, $action, $routeMethod, $security) = array_values($route);

            if ($routeMethod !== $method) {
                $this->methodNotAllowed();
                return;
            }

            $params = $this->parseParams($routeOriginal, $formattedRoute);

            if (false === $this->checkRouteConstraints($routeOriginal, $params)) {
                $this->methodNotFound();

                return;
            }

            if(true === $security) {
                $securityObj = new Security($this->getSecurityToken($params));
                if(false === $securityObj->validate()) {
                    $this->methodUnauthorized();
                    return;
                }
            }
            
            $controller = $this->getNamespace() . $controller . 'Controller';
            if (class_exists($controller)) {

                $controllerObj = new $controller($params);
                $action        = $action . 'Action';

                if (is_callable([$controllerObj, $action])) {

                    $response = $controllerObj->{$action}($params);


                    $response->send();
                }

            }
        } // if route not exist
        else {
            $this->methodNotFound();
        }
    }

    /**
     * @param array $params
     *
     * @return string
     */
    protected function getSecurityToken(array $params)
    {
        return array_key_exists('token', $params) ? $params['token'] : '';
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    protected function getRouteOption(string $routeName, string $key)
    {
        $route = $this->getRouteByName($routeName);

        return array_key_exists($key, $route) ? $route[$key] : false;
    }


    /**
     * @param string $name
     *
     * @return array
     */
    protected function getRouteByName(string $name): array
    {
        return array_key_exists($name, $this->getRoutes()) ? $this->getRoutes()[$name] : false;
    }

    /**
     * @return array
     */
    protected function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     *
     * @return string
     */
    protected function getNamespace(): string
    {
        $namespace = 'Src\Controller\\';

        return $namespace;
    }
}