<?php
/**
 * A custom Composer command.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts\Commands;

use Composer\Console\Input\InputArgument;
use lloc\ComposerI18nScripts\I18nConfig;
use Symfony\Component\Console\Input\InputInterface;

/**
 * A custom Composer command.
 */
class CreatePoCommand extends CustomCommand {

	/**
	 * Configures the command.
	 */
	protected function configure(): void {
		$this
			->setName( 'i18n:create-po' )
			->setDescription( 'Creates a .po file for a specific language from the .pot template.' )
			->setHelp(
				<<<'EOT'
This command uses WP-CLI to generate a .po translation file for the given language,
based on the .pot file in your configured languages directory.

Usage:
  composer i18n:create-po de_DE

The language code (e.g., de_DE, fr_FR) is required.

Configuration is read from the plugin or theme headers.
EOT
			)
			->addArgument(
				'locale',
				InputArgument::REQUIRED,
				'Locale code of a language (e.g., de_DE)'
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
		$locale = $input->getArgument( 'locale' );

		return sprintf(
			'if [ ! -e %1$s ]; then cp %2$s %1$s; fi',
			escapeshellarg( $config->translation( $locale ) ),
			escapeshellarg( $config->destination() )
		);
	}
}
