<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.09.2018
 * Time: 20:16
 */

namespace Core\Http\Response;

interface IResponse
{
    public function send();

    public function setStatusCode(int $code): void;

    public function setContent($content): void;

    public function addHeaders(array $headers): void;

}