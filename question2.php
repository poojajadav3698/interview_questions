<?php
/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 1:41 PM
 */
require_once 'imageMagic.php';
require_once 'command.php';

if(PHP_OS === "Linux")
{
	$image_magic_obj = new imageMagic("/usr/local/imagemagick");
	echo $image_magic_obj->getImageMagicPath();

	//initialize the command class
	$command_obj = new command("convert -limit memory 0 -limit map 0 -quiet ",
		"profile.jpg",
		" -thumbnail @11000 -quality 50 ",
		"output.png"
	);

	//get base path
	$command = $command_obj->getBaseCommand();
	//get original file path
	$command .= $command_obj->getOriginPath();
	//get parameters
	$command .= $command_obj->getParams();
	//get target path
	$command .= $command_obj->getTargetPath();

	//run the command
	$output = shell_exec($command);

	return $output;
}
else if(PHP_OS === "Windows")
{

}
?>
