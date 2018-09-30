<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 15:49
 */

namespace Core\Security;

/**
 * Class TokenGenerator
 * @package Core\Security
 */
class TokenGenerator
{
    /**
     * @var string
     */
    protected $string;

    /**
     * TokenGenerator constructor.
     *
     * @param string $string
     */
    public function __construct(string $string = '')
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        return md5(uniqid($this->string));
    }
}