<?php

namespace Mactronique\Deployer;

use Symfony\Component\Console\Application;

class DeployerApp extends Application
{
    protected $config;
    
    protected $configPath;

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
}
