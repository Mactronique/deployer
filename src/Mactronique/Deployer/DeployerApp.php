<?php

namespace Mactronique\Deployer;

use Symfony\Component\Console\Application;

class DeployerApp extends Application
{
    protected $config;
    
    protected $configPath;

    protected $projectPath;

    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Gets the value of configPath.
     *
     * @return mixed
     */
    public function getConfigPath()
    {
        return $this->configPath;
    }

    /**
     * Sets the value of configPath.
     *
     * @param mixed $configPath the config path
     *
     * @return self
     */
    public function setConfigPath($configPath)
    {
        $this->configPath = $configPath;

        return $this;
    }

    /**
     * Gets the value of projectPath.
     *
     * @return mixed
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    /**
     * Sets the value of projectPath.
     *
     * @param mixed $projectPath the project path
     *
     * @return self
     */
    public function setProjectPath($projectPath)
    {
        $this->projectPath = $projectPath;

        return $this;
    }
}
