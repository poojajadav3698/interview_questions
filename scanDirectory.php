<?php

/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 8:35 PM
 */
class ScanDirectory
{
    private $dir_path;

    public function __construct($dir_path)
    {
        $this->dir_path = $dir_path;
    }

    public function isValidPath()
    {
        return file_exists($this->dir_path) && is_readable($this->dir_path);
    }

    public function loadFiles()
    {
        return array_diff(scandir($this->dir_path), array('..', '.'));
    }
    public function isDirectory($name)
    {
        return is_dir($this->dir_path. DIRECTORY_SEPARATOR . $name);
    }
}