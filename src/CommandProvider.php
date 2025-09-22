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
use lloc\ComposerI18nScripts\Commands\CreatePoCommand;
use lloc\ComposerI18nScripts\Commands\MakeJsonCommand;
use lloc\ComposerI18nScripts\Commands\MakeMoCommand;
use lloc\ComposerI18nScripts\Commands\MakePhpCommand;
use lloc\ComposerI18nScripts\Commands\MakePotCommand;
use lloc\ComposerI18nScripts\Commands\UpdatePoCommand;

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
		return array(
			new CreatePoCommand(),
			new MakeJsonCommand(),
			new MakeMoCommand(),
			new MakePhpCommand(),
			new MakePotCommand(),
			new UpdatePoCommand(),
		);
	}
}
