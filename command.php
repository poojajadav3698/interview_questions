<?php

/**
 * Created by PhpStorm.
 * User: vidura
 * Date: 5/08/17
 * Time: 6:08 PM
 */

/**
 * Class command
 */
class Command
{
    /**
     * @var $base_command - this represents the basic command. Ex : convert.
     */
    private $base_command;

    /**
     * @var $origin_path - this represents the original file path to be converted.
     */
    private $origin_path;

    /**
     * @var $params - (parameters)
     */
    private $params;

    /**
     * @var $target_path - this represents the path of the file to be saved.
     */
    private $target_path;

    /**
     * command constructor
     * @param $base_command
     * @param $origin_path
     * @param $params
     * @param $target_path
     */
    public function __construct($base_command, $origin_path, $params, $target_path)
    {
        $this->base_command = $base_command;
        $this->origin_path = $origin_path;
        $this->params = $params;
        $this->target_path = $target_path;
    }

    /**
     * Function - getBaseCommand
     * @return String
     */
    public function getBaseCommand()
    {
        return $this->base_command;
    }

    /**
     * Function - getOriginPath
     * @return String
     */
    public function getOriginPath()
    {
        return $this->origin_path;
    }

    /**
     * Function - getParams
     * @return String
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Function - getTargetPath
     * @return String
     */
    public function getTargetPath()
    {
        return $this->target_path;
    }

    /**
     * Function - execute
     * @param $command
     * @return string
     */
    public function execute($command)
    {
        return shell_exec($command);
    }
}