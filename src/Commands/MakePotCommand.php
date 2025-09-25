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
class MakePotCommand extends CustomCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this
			->setName( 'i18n:make-pot' )
			->setDescription( 'Generates a .pot file for your plugin or theme.' )
			->setHelp(
				<<<'EOT'
This command uses WP-CLI to generate a .pot file for your WordPress plugin or theme.

Example:
  composer i18n:make-pot

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
			'wp i18n make-pot %s %s',
			escapeshellarg( $config->source() ),
			escapeshellarg( $config->destination() )
		);
	}
}
