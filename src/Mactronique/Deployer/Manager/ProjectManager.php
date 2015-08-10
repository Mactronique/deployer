<?php

namespace Mactronique\Deployer\Manager;
use Mactronique\Deployer\Adapter\CvsAdapter;

class ProjectManager
{
    private $projects;

    /**
     * Array contains all system of Control of Version for Sources
     */
    private $system;

    public function __construct(array $projects)
    {
        $this->$projects = $projects;
    }

    public function add($name, $url)
    {

    }

    public function getList()
    {

    }

    public function remove($name)
    {

    }

    public function addCVS(CvsAdapter $system)
    {
        $this->system[$system->getName()] = $system;
    }

    private function save()
    {

    }
}
