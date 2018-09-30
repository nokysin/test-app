<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 26.09.2018
 * Time: 18:38
 */

namespace Core\Http\Request;

/**
 * Class Request
 */
class Request implements IRequest
{

    const HTTP_GET  = 'GET';
    const HTTP_POST = 'POST';

    /**
     * Request constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    /**
     * @return void
     */
    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * @param $string string
     *
     * @return mixed|string
     */
    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);
        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        if ($this->requestMethod === self::HTTP_GET) {
            return [];
        }
        if ($this->requestMethod == self::HTTP_POST) {
            $result = [];
            foreach ($_POST as $key => $value) {
                $result[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $result;
        }

        return $body;
    }
}