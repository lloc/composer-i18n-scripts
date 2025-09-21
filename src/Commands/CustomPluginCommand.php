<?php
/**
 * A custom Composer command.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

/**
 * A custom Composer command.
 */
class CustomPluginCommand extends BaseCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this->setName( 'custom-plugin-command' );
	}

	/**
	 * Executes the command.
	 *
	 * @param InputInterface  $input  The input interface.
	 * @param OutputInterface $output The output interface.
	 * @return int Exit code.
	 */
	protected function execute( InputInterface $input, OutputInterface $output ): int {
		$output->writeln( 'Executing' );

		return 0;
	}
}
