<?php
/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 1:41 PM
 */
require_once 'imageMagic.php';
require_once 'command.php';

if (PHP_OS === "Linux") {
    $image_magic_obj = new ImageMagic("/usr/local/imagemagick");
    $isValidPath = $image_magic_obj->isValidPath();

    if ($isValidPath) {
        //initialize the command class
        $command_obj = new Command(
            "convert -limit memory 0 -limit map 0 -quiet ",
            "profile.jpg",
            " -thumbnail @11000 -quality 50 ",
            "output.png"
        );

        //get ImageMagic Path
        //$command = $image_magic_obj->getImageMagicPath();
        //get base path
        $command = $command_obj->getBaseCommand();
        //get original file path
        $command .= $command_obj->getOriginPath();
        //get parameters
        $command .= $command_obj->getParams();
        //get target path
        $command .= $command_obj->getTargetPath();

        //run the command
        $output = $command_obj->execute($command);

        if($output)
        {
            echo "converted successfully.";
        }
    }
    else
    {
        echo "Could not found image magic.";
    }

} else if (PHP_OS === "Windows") {
    $image_magic_obj = new ImageMagic("c:\tools\imagemagick.exe");
    $isFileExist = $image_magic_obj->isFileExist();

    if ($isFileExist) {
        //initialize the command class
        $command_obj = new Command(
            "convert -limit memory 0 -limit map 0 -quiet ",
            "profile.jpg",
            " -thumbnail @11000 -quality 50 ",
            "output.png"
        );

        //get ImageMagic Path
        //$command = $image_magic_obj->getImageMagicPath();
        //get base path
        $command = $command_obj->getBaseCommand();
        //get original file path
        $command .= $command_obj->getOriginPath();
        //get parameters
        $command .= $command_obj->getParams();
        //get target path
        $command .= $command_obj->getTargetPath();

        //run the command
        $output = $command_obj->execute($command);

        if($output)
        {
            echo "converted successfully.";
        }
    }
    else
    {
        echo "Could not found image magic executable path.";
    }
}
?>
