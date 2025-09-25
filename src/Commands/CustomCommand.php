<?php
/**
 * Base class for custom commands.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts\Commands;

use Composer\Command\BaseCommand;
use lloc\ComposerI18nScripts\I18nConfig;
use lloc\ComposerI18nScripts\ShellRunner;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base class for custom commands.
 */
abstract class CustomCommand extends BaseCommand {

	public const SUCCESS = 0;
	public const ERROR   = 1;

	/**
	 * Exec encapsulation.
	 *
	 * @var ShellRunner
	 */
	protected ShellRunner $runner;

	/**
	 * The custom command constructor.
	 *
	 * @param ShellRunner $runner The constructor accepts a ShellRunner object.
	 */
	public function __construct( ShellRunner $runner ) {
		parent::__construct();

		$this->runner = $runner;
	}

	/**
	 * Returns the command with its parameters so it can be executed.
	 *
	 * @param I18nConfig     $config The i18n configuration.
	 * @param InputInterface $input The input interface.
	 * @return string The command with its parameters.
	 */
	abstract protected function command( I18nConfig $config, InputInterface $input ): string;

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

		$command = $this->command( $config, $input );

		$output->writeln( '<info>Running: ' . $command . '</info>' );

		$this->runner->exec( $command, $output_lines, $exit_code );

		foreach ( $output_lines as $line ) {
			$output->writeln( $line );
		}

		if ( self::SUCCESS !== $exit_code ) {
			$output->writeln( '<error>Command failed with exit code ' . $exit_code . '</error>' );
			return $exit_code;
		}

		$output->writeln( '<info>Command succeeded.</info>' );

		return self::SUCCESS;
	}
}
