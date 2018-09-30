<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 29.09.2018
 * Time: 02:18
 */

namespace Core\Security;

/**
 * Class Security
 * @package Core
 */
class Security
{
    /**
     * @var string
     */
    protected $token;

    /**
     * Security constructor.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return strlen($this->token) == 32 && ctype_xdigit($this->token);
    }
}