<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 28.09.2018
 * Time: 01:43
 */

namespace Core;

/**
 * Class Autoloader
 * @package Core
 */
class Autoloader
{
    /**
     * @var array
     */
    protected $prefixes = [];

    /**
     * Register loader
     *
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * @param string $prefix
     * @param string $baseDir
     * @param bool   $prepend
     *
     * @return void
     */
    public function addNamespace(string $prefix, string $baseDir, $prepend = false) : void
    {
        $prefix  = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';

        if (false === isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = [];
        }

        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $baseDir);
        } else {
            array_push($this->prefixes[$prefix], $baseDir);
        }
    }

    /**
     * @param string $class
     *
     * @return bool|mixed
     */
    public function loadClass(string $class)
    {
        $prefix = $class;

        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix         = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file    = $this->loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }

        return false;
    }

    /**
     * @param $prefix
     * @param $relative_class
     *
     * @return bool|string
     */
    protected function loadMappedFile($prefix, $relative_class)
    {
        if (false === isset($this->prefixes[$prefix])) {
            return false;
        }

        foreach ($this->prefixes[$prefix] as $base_dir) {
            $file = $base_dir
                    . str_replace('\\', '/', $relative_class)
                    . '.php';

            if ($this->requireFile($file)) {
                return $file;
            }
        }

        return false;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function requireFile(string $file): bool
    {
        $file = '../' . $file;
        if (file_exists($file)) {
            require $file;

            return true;
        }

        return false;
    }
}
