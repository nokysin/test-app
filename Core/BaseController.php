<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 29.09.2018
 * Time: 02:41
 */

namespace Core;

use Core\Http\Response\Response;

/**
 * Class BaseController
 * @package Core
 */
class BaseController
{
    /**
     * @var array
     */
    protected $params;

    /**
     * BaseController constructor.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $content
     * @param int    $statusCode
     * @param string $type
     *
     * @return \Core\Http\Response\Response
     */
    protected function response($content = '', int $statusCode = Response::HTTP_OK, $type = 'json')
    {
        $headers = Response::HEADERS_BY_TYPE[$type];

        return new Response(json_encode($content), $statusCode, $headers);
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    protected function responseNotFound()
    {
        $statusCode = Response::HTTP_NOT_FOUND;

        return $this->response([
            'code'    => $statusCode,
            'message' => Response::$statusTexts[$statusCode],
        ], $statusCode);
    }

    /**
     * @param $model
     */
    public function getRepository(string $model)
    {
        $model = substr($model, strrpos($model, '\\') + 1);
        $repository = 'Src\\Repository\\' . $model . 'Repository';

        return new $repository($model);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    protected function getParam(string $key)
    {
        $params = $this->params;

        return array_key_exists($key, $params) ? $params[$key] : null;
    }
}