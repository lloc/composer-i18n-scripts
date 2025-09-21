<?php

namespace lloc\ComposerI18nScripts;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

class ComposerPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    protected Composer $composer;
    protected IOInterface $io;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public static function getSubscribedEvents()
    {
        return array();
    }

    /**
     * @return array<string, class-string>
     */
    public function getCapabilities(): array
    {
        return array(
            'Composer\Plugin\Capability\CommandProvider' => CommandProvider::class,
        );
    }
}
