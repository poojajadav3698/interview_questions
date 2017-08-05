<?php
/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 8:31 PM
 */
require_once 'scanDirectory.php';

/**
 * Initialize ScanDirectory class
 */
$scan_obj = new ScanDirectory(
    'my_directory'//path of the directory
);

print_r($scan_obj->printAllFilesAndDirectories());

