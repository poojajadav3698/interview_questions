<?php
/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 8:31 PM
 */
require_once 'scanDirectory.php';

$file_names = array();

function getFileNames($dir)
{
    //echo "call get file names"."<br>";
    $scan_obj = new ScanDirectory(
        $dir
    );

    if($scan_obj->isValidPath())
    {
        $contents = $scan_obj->loadFiles();

        if(count($contents) > 0)
        {
            foreach($contents as $content)
            {
                if($scan_obj->isDirectory($content))
                {
                    $file_names[] = array("is_directory" => true, "name" => $content);;
                    //echo ($content)." ".$scan_obj->isDirectory($content)."<br> ";
                    $sub_dir_path = $dir.DIRECTORY_SEPARATOR.$content;
                    //echo $sub_dir_path."<br>";
                    getFileNames($sub_dir_path);
                }
                else
                {
                    echo ($content);
                    echo "<br>";
                    $file_names[] = array("is_directory" => false, "name" => $content);
                }
            }
        }

        return $file_names;
    }
    else
    {
        return "Invalid file path.";
    }

}

echo json_encode(getFileNames('my_directory'));

