<?php
/**
 * Test of MakePotCommand
 */

declare(strict_types=1);

namespace lloc\ComposerI18nScriptsTests\Commands;

use lloc\ComposerI18nScripts\Commands\MakePotCommand;

use lloc\ComposerI18nScripts\ShellRunner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class MakePotCommandTest extends TestCase {

	public function testCommandIsRegisteredAndConfigured(): void {
        $runner = new ShellRunner();
		$application = new Application();
		$application->add( new MakePotCommand($runner) );

		$command = $application->find( 'i18n:make-pot' );
		$this->assertSame( 'i18n:make-pot', $command->getName() );
		$this->assertNotEmpty( $command->getDescription() );
		$this->assertNotEmpty( $command->getHelp() );
	}

	public function testCommandExecutionReturnsSuccess(): void {
        $runner = new ShellRunner();
		$application = new Application();
		$application->add( new MakePotCommand($runner) );

		$command = $application->find( 'i18n:make-pot' );
		$tester  = new CommandTester( $command );

		// You may need to mock or override shell exec inside the command to make this testable
		$tester->execute( array() );

		// Just test if it runs (for now)
		$this->assertSame( 0, $tester->getStatusCode() );
	}
}
