<?php

namespace lloc\ComposerI18nScripts\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class CustomPluginCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('custom-plugin-command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing');

        return 0;
    }
}