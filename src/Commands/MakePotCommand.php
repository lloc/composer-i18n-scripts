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
use lloc\ComposerI18nScripts\I18nConfig;

/**
 * A custom Composer command.
 */
class MakePotCommand extends BaseCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this
			->setName( 'i18n:make-pot' )
			->setDescription( 'Generates a .pot file for your plugin or theme.' )
			->setHelp( 'This command runs WP-CLI\'s i18n make-pot command using configured paths and text domain.' );
	}

	/**
	 * Executes the command.
	 *
	 * @param InputInterface  $input  The input interface.
	 * @param OutputInterface $output The output interface.
	 * @return int Exit code.
	 */
	protected function execute( InputInterface $input, OutputInterface $output ): int {
		$config = I18nConfig::from_composer( $this->requireComposer() );

		if ( ! $config->destination() ) {
			$output->writeln( '<error>Text domain is not set in the configuration file.</error>' );
			return 1;
		}

		$command = sprintf(
			'wp i18n make-pot %s %s',
			escapeshellarg( $config->source() ),
			escapeshellarg( $config->destination() )
		);

		$output->writeln( '<info>Running: ' . $command . '</info>' );

		exec( $command, $output_lines, $exit_code );

		foreach ( $output_lines as $line ) {
			$output->writeln( $line );
		}

		if ( 0 !== $exit_code ) {
			$output->writeln( '<error>Command failed with exit code ' . $exit_code . '</error>' );
			return $exit_code;
		}

		$output->writeln( '<info>.pot file generated successfully.</info>' );
		return 0;
	}
}
