<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 14:59
 */

namespace Src\Model;

use Core\ModelAbstract;

/**
 * Class User
 * @package Src\Model
 */
class User extends ModelAbstract
{
    /**
     * @var string
     */
    protected $login;

    /**
     * @var
     */
    protected $password;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}