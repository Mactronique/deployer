<?php

namespace Mactronique\Deployer;

use Symfony\Component\Console\Application;

class DeployerApp extends Application
{
    protected $config;
    
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
    	return $this->config;
    }
}
