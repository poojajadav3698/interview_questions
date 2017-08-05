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
class imageMagic
{
    /**
     * @var $image_magic_path - path of the image magic.
     */
    private $image_magic_path;

    public function __construct ( $image_magic_path) {
        $this->image_magic_path = $image_magic_path;
    }
    public function getImageMagicPath()
    {
        return $this->image_magic_path;
    }
}