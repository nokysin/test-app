<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 12:53
 */

namespace Src\Model;

use Core\ModelAbstract;

/**
 * Class Cost
 * @package Src\Model
 */
class Cost extends ModelAbstract
{

    /**
     * @var integer
     */
    protected $value;

    /**
     * @var string
     */
    protected $date;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }
}