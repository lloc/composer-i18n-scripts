<?php
/**
 * Shell encapsulation class
 *
 * @package lloc\ComposerI18nScripts
 */

declare(strict_types=1);

namespace lloc\ComposerI18nScripts;

/**
 * Class ShellRunner
 */
class ShellRunner {

	/**
	 * Executes a shell command.
	 *
	 * @param string    $command The command to execute.
	 * @param string[] $output The output in an array.
	 * @param int      $result_code The result code of the command execution.
	 * @return void
	 */
	public function exec( string $command, array &$output, int &$result_code ): void {
        // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.system_calls_exec
		exec( $command, $output, $result_code );
	}
}
