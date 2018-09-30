<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 13:11
 */

namespace Core\FileReader;

/**
 * Class ReaderAbstract
 * @package Core\FileReader
 */
class ReaderAbstract
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $model;

    /**
     * ReaderAbstract constructor.
     *
     * @param string $model
     */
    public function __construct(string $model, string $type)
    {
        $filePath    = '../data/' . $model . '.' . $type;
        $this->model = $model;
        $this->file  = $this->loadFile($filePath);
    }

    /**
     * @param string|bool $filePath
     */
    protected function loadFile($filePath)
    {
        return file_exists($filePath) ? $filePath : false;
    }
}