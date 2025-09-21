<?php
/**
 * Command Provider for the custom Composer commands.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use lloc\ComposerI18nScripts\Commands\CustomPluginCommand;

/**
 * Class CommandProvider
 */
class CommandProvider implements CommandProviderCapability {

	/**
	 * Returns an array of custom commands.
	 *
	 * @return array An array of custom commands.
	 */
	public function getCommands() {
		return array( new CustomPluginCommand() );
	}
}
