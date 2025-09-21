<?php

namespace lloc\ComposerI18nScripts;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use lloc\ComposerI18nScripts\Commands\CustomPluginCommand;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return array(new CustomPluginCommand());
    }
}
