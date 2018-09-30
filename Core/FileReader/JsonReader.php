<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 13:10
 */

namespace Core\FileReader;

/**
 * Class JsonReader
 * @package Core\FileReader
 */
class JsonReader extends ReaderAbstract
{

    const TYPE = 'json';

    public function __construct(string $model)
    {
        parent::__construct($model, self::TYPE);
    }

    /**
     * @return mixed
     */
    public function getDataFromFile()
    {
        if (false === file_get_contents($this->file)) {
            $model = $this->model;
            throw new \Exception("Repository {$model} file not found");
        }

        return json_decode(file_get_contents($this->file), true);
    }
}