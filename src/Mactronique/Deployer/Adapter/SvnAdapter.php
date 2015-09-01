<?php

namespace Mactronique\Deployer\Adapter;

use Composer\Util\ProcessExecutor;

class SvnAdapter implements CvsAdapter
{
    private $config;

    public function __constructor($config)
    {
        $this->config = $config;
    }

    public function extractTo($url, $path, $version = null)
    {
        //1 open process
        //2 get tool path
        //3 launch process
    }

    /**
     * allow get deployer configuration from repository
     */
    public function getDeployerConfig($url, $version = null)
    {

    }

    protected function getCommand($cmd, $url, $path = null)
    {
        $command = sprintf('%s %s%s %s', $cmd, '--non-interactive ', $this->getCredentialString(), ProcessExecutor::escape($url));
            
        if ($path) {
            $command.= ProcessExecutor::escape($path);
        }

        return $command;
    }

    protected function getCredentialString()
    {
        if (!array_key_exists('credentials', $this->config)) {
            return '';
        }

        return sprintf(
            ' %s--username %s --password %s ',
            $this->getAuthCache(),
            ProcessExecutor::escape($this->getUsername()),
            ProcessExecutor::escape($this->getPassword())
        );
    }

    protected function getAuthCache()
    {
        return array_key_exists('no-cache', $this->config['credentials']);
    }

    protected function getUsername()
    {
        return $this->config['credentials']['username'];
    }

    protected function getPassword()
    {
        return array_key_exists('password', $this->config['credentials'])? $this->config['credentials']['password']:'';
    }
}
