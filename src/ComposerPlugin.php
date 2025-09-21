<?php
/**
 * Composer Plugin for i18n scripts.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

/**
 * Class ComposerPlugin
 */
class ComposerPlugin implements PluginInterface, EventSubscriberInterface, Capable {

	/**
	 * This represents Composer as an object.
	 *
	 * @var Composer
	 */
	protected Composer $composer;

	/**
	 * This is used to interact with the user.
	 *
	 * @var IOInterface
	 */
	protected IOInterface $io;

	/**
	 * Activate the plugin.
	 *
	 * @param Composer    $composer Activation has access to the Composer instance.
	 * @param IOInterface $io       Activation has access to the IOInterface.
	 *
	 * @return void
	 */
	public function activate( Composer $composer, IOInterface $io ): void {
		$this->composer = $composer;
		$this->io       = $io;
	}

	/**
	 * Deactivate the plugin.
	 *
	 * @param Composer    $composer Deactivation has access to the Composer instance.
	 * @param IOInterface $io       Deactivation has access to the IOInterface.
	 *
	 * @return void
	 */
	public function deactivate( Composer $composer, IOInterface $io ): void {
	}

	/**
	 * Uninstall the plugin.
	 *
	 * @param Composer    $composer Uninstallation has access to the Composer instance.
	 * @param IOInterface $io       Uninstallation has access to the IOInterface.
	 *
	 * @return void
	 */
	public function uninstall( Composer $composer, IOInterface $io ): void {
	}

	/**
	 * Returns an array of events this plugin subscribes to.
	 *
	 * @return array<string, string>
	 */
	public static function getSubscribedEvents() {
		return array();
	}

	/**
	 * Returns an array of capabilities this plugin provides.
	 *
	 * @return array<string, class-string>
	 */
	public function getCapabilities(): array {
		return array(
			'Composer\Plugin\Capability\CommandProvider' => CommandProvider::class,
		);
	}
}
