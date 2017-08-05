<?php

/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 5:55 PM
 */

/**
 * Class imageMagic
 */
class ImageMagic
{
    /**
     * @var $image_magic_path - path of the image magic.
     */
    private $image_magic_path;

    /**
     * ImageMagic constructor.     *
     * @param $image_magic_path
     */
    public function __construct($image_magic_path)
    {
        $this->image_magic_path = $image_magic_path;
    }

    /**
     * Function - getImageMagicPath     *
     * @return mixed
     */
    public function getImageMagicPath()
    {
        return $this->image_magic_path;
    }

    /**
     * Function - isValidPath
     * @return bool
     */
    public function isValidPath()
    {
        return file_exists($this->image_magic_path) && is_readable($this->image_magic_path);
    }

    /**
     * Function - isFileExist     *
     * @return bool
     */
    public function isFileExist()
    {
        return file_exists($this->image_magic_path);
    }
}