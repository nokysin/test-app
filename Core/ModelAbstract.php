<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 15:37
 */

namespace Core;

/**
 * Class ModelAbstract
 * @package Core
 */
class ModelAbstract
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param array $values
     *
     * @return \Core\ModelAbstract
     */
    public function toObject(array $values): ModelAbstract
    {
        $properties = get_object_vars($this);

        foreach ($properties as $key => $property) {
            if (array_key_exists($key, $values)) {
                $method = 'set' . ucfirst($key);

                if (is_callable([$this, $method])) {
                    $this->$method($values[$key]);
                }
            }
        }

        return $this;
    }
}