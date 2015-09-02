<?php

namespace Mactronique\Deployer\Manager;

use Mactronique\Deployer\Adapter\CvsAdapter;

class ProjectManager
{
    private $projects;

    private $cachePath;

    private $cache;

    /**
     * Array contains all system of Control of Version for Sources
     */
    private $system;

    public function __construct(array $projects, $cachePath)
    {
        $this->$projects = $projects;
        $this->cachePath = $cachePath;
    }

    public function getList()
    {

    }

    public function getInfos($projectName)
    {

    }

    public function addCVS(CvsAdapter $system)
    {
        $this->system[$system->getName()] = $system;
    }

    private function saveCache()
    {

    }

    private function loadCache()
    {
        if (!file_exists($this->cachePath)) {
            return [];
        }
        $content = file_get_contents($projectPath);

        if (empty($content)) {
            return [];
        }
        
        return unserialize($content);
    }
}
