<?php
/**
 * Test of MakeJsonCommand
 */

declare(strict_types=1);

namespace lloc\ComposerI18nScriptsTests\Commands;

use lloc\ComposerI18nScripts\Commands\MakeJsonCommand;
use lloc\ComposerI18nScripts\ShellRunner;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\Console\Application;

#[CoversClass(MakeJsonCommand::class)]
class MakeJsonCommandTest extends TestCase {

    protected Application $application;

    protected function setUp(): void {
        $runner = $this->createMock(ShellRunner::class);
        $runner->method('exec')
            ->willReturnCallback(function ($cmd, &$output, &$exitCode) {
                $output = ['Mocked .json generation'];
                $exitCode = 0;
            });

        $command = new MakeJsonCommand($runner);

        $this->application = new Application();
        $this->application->setAutoExit(false); // Important for tests
        $this->application->add($command);
    }


    public function testCommandIsRegisteredAndConfigured(): void {
        $command = $this->application->find( 'i18n:make-json' );

        $this->assertSame( 'i18n:make-json', $command->getName() );
        $this->assertNotEmpty( $command->getDescription() );
        $this->assertNotEmpty( $command->getHelp() );
    }
}
