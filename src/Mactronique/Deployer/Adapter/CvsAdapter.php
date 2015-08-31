<?php

namespace Mactronique\Deployer\Adapter;

interface CvsAdapter
{
    public function extractTo($url, $path, $version = null);
}