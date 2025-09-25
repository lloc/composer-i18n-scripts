<?php
/**
 * A custom Composer command.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts\Commands;

use lloc\ComposerI18nScripts\I18nConfig;
use Symfony\Component\Console\Input\InputInterface;

/**
 * A custom Composer command.
 */
class MakePhpCommand extends CustomCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this
			->setName( 'i18n:make-php' )
			->setDescription( 'Generates PHP translation files from .po files for your plugin or theme.' )
			->setHelp(
				<<<'EOT'
This command uses WP-CLI to generate PHP translation files from existing .po files 
in your languages directory.

The resulting .php files contain translation arrays, which can be used as an alternative 
to .mo files in certain WordPress or performance-critical setups.

Example:
  composer i18n:make-php

Configuration is read from the plugin or theme headers.
EOT
			);
	}
	/**
	 * Returns the command with its parameters so it can be executed.
	 *
	 * @param I18nConfig     $config The i18n configuration.
	 * @param InputInterface $input The input interface to get arguments passed to the command.
	 * @return string The command with its parameters.
	 */
	protected function command( I18nConfig $config, InputInterface $input ): string {
		return sprintf(
			'wp i18n make-php %s',
			escapeshellarg( $config->languages_path() )
		);
	}
}
