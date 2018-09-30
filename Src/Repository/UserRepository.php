<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 13:01
 */

namespace Src\Repository;

use Core\ModelAbstract;
use Core\RepositoryAbstract;

/**
 * Class CostRepository
 * @package Src\Repository
 */
class UserRepository extends RepositoryAbstract
{

    /**
     * @param string $login
     * @param string $password
     *
     * @return ModelAbstract
     */
    public function findByLoginAndPassword($login, $password)
    {
        $users = $this->findAll();

        $userValue = [];
        foreach ($users as $id => $user) {
            if ($login === $user['login'] && $password === $user['password']) {
                $userValue = $user;

                return $this->getModel()->toObject($userValue);
            }
        }

        return $userValue;
    }

    /**
     * @param integer $id
     */
    public function findById(int $id)
    {
        $costs = $this->findAll();

        return array_key_exists($id, $costs) ? $costs[$id] : [];
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getData();
    }
}