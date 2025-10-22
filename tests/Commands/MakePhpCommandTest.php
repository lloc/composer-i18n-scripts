<?php
/**
 * Test of MakePotCommand
 */

declare(strict_types=1);

namespace Commands;

use lloc\ComposerI18nScripts\Commands\MakePhpCommand;

use lloc\ComposerI18nScripts\ShellRunner;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

#[CoversClass(MakePhpCommand::class)]
class MakePhpCommandTest extends TestCase {

    protected Application $application;

    protected function setUp(): void {
        $runner = $this->createMock(ShellRunner::class);
        $runner->method('exec')
            ->willReturnCallback(function ($cmd, &$output, &$exitCode) {
                $output = ['Mocked .php generation'];
                $exitCode = 0;
            });

        $command = new MakePhpCommand($runner);

        $this->application = new Application();
        $this->application->setAutoExit(false); // Important for tests
        $this->application->add($command);
    }

	public function testCommandIsRegisteredAndConfigured(): void {
		$command = $this->application->find( 'i18n:make-php' );

		$this->assertSame( 'i18n:make-php', $command->getName() );
		$this->assertNotEmpty( $command->getDescription() );
		$this->assertNotEmpty( $command->getHelp() );
	}
}
