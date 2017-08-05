<?php

/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 8:35 PM
 */
class ScanDirectory
{
    private $directoryPath;

    /**
     * ScanDirectory constructor.
     * @param $directoryPath - path of the directory
     */
    public function __construct($directoryPath)
    {
        $this->directoryPath = $directoryPath;
    }

    /**
     * Function isValidPath
     * @return bool
     */
    public function isValidPath()
    {
        return file_exists($this->directoryPath) && is_readable($this->directoryPath);
    }

    /**
     * Function printAllFilesAndDirectories
     * @return array
     */
    public function printAllFilesAndDirectories()
    {
        if (!$this->isValidPath()) {
            return "Invalid file path.";
        }
        return $this->dirToArray($this->directoryPath);
    }

    /**
     * Function dirToArray
     *
     * @param $dir
     * @param array $results
     * @return array
     */
    public function dirToArray($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path . '(file)';
            } else if ($value != "." && $value != "..") {
                $this->dirToArray($path, $results);
                $results[] = $path . '(dir)';
            }
        }
        return $results;
    }
}