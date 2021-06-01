<?php

namespace JoulesLabs\Warehouse\Config;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use JoulesLabs\Warehouse\Foundation\Provider;

class ConfigProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     */
    public function booting()
    {
        $config = new Config(['app' => $this->app->getAppConfig()]);

        $this->app->bindInstance(
            'config',
            $config,
            'Config',
            Config::class
        );
    }

    /**
     * The provider booted method to be called after booting
     */
    public function booted()
    {
        $this->loadConfig();
    }

    /**
     * Loads all configuration files from config directory
     */
    public function loadConfig()
    {
        $configPath = $this->app->configPath();
        $itr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            $configPath,
            RecursiveDirectoryIterator::SKIP_DOTS
        ));

        foreach ($itr as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php' && $file->getFileName() != 'app.php') {
                $fileRealPath = $file->getRealPath();
                $directory = $this->getDirectory($file, $configPath);
                $this->app->config->set($directory.basename($fileRealPath, '.php'), include $fileRealPath);
            }
        }
    }

    /**
     * Get nested directory names joined by a "."
     *
     * @param string $file       [A config file]
     * @param string $configPath
     *
     * @return string
     */
    protected function getDirectory($file, $configPath)
    {
        $ds = DIRECTORY_SEPARATOR;

        if ($directory = trim(str_replace(trim($configPath, '/'), '', $file->getPath()), $ds)) {
            $directory = str_replace($ds, '.', $directory).'.';
        }

        return $directory;
    }
}
