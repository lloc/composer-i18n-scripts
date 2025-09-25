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
class MakeJsonCommand extends CustomCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this
			->setName( 'i18n:make-json' )
			->setDescription( 'Generates JSON translation files for JavaScript internationalization.' )
			->setHelp(
				<<<'EOT'
This command uses WP-CLI to generate .json translation files for your WordPress plugin or theme, 
typically used for JavaScript i18n support.

It scans the configured source directory for JavaScript translation functions and outputs the 
resulting .json files into the languages directory.

Example:
  composer i18n:make-json

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
			'wp i18n make-json %s --no-purge',
			escapeshellarg( $config->languages_path() )
		);
	}
}
