<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 13:01
 */

namespace Src\Repository;

use Core\RepositoryAbstract;

/**
 * Class CostRepository
 * @package Src\Repository
 */
class CostRepository extends RepositoryAbstract
{

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