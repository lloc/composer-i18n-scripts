<?php
/**
 * Command Provider for the custom Composer commands.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts;

use Composer\Command\BaseCommand;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use lloc\ComposerI18nScripts\Commands\MakePotCommand;

/**
 * Class CommandProvider
 */
class CommandProvider implements CommandProviderCapability {

	/**
	 * Returns an array of custom commands.
	 *
	 * @return BaseCommand[] An array of custom commands.
	 */
	public function getCommands(): array {
		return array( new MakePotCommand() );
	}
}
