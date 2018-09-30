<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 13:02
 */

namespace Core;

use Core\FileReader\JsonReader;

/**
 * Class RepositoryAbstract
 * @package Core
 */
class RepositoryAbstract
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * RepositoryAbstract constructor.
     *
     * @param string $model
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->data  = $this->getReader()->getDataFromFile();

    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \Core\FileReader\JsonReader
     */
    protected function getReader()
    {
        return new JsonReader($this->model);
    }

    /**
     * @return \Core\ModelAbstract
     */
    protected function getModel(): ModelAbstract
    {
        $modelName = $this->model;

        $model = 'Src\\Model\\' . $modelName;

        return new $model();
    }
}