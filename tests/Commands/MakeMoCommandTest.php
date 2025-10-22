<?php
/**
 * Test of MakeMoCommand
 */

declare(strict_types=1);

namespace Commands;

use lloc\ComposerI18nScripts\Commands\MakeMoCommand;
use lloc\ComposerI18nScripts\ShellRunner;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

#[CoversClass(MakeMoCommand::class)]
class MakeMoCommandTest extends TestCase {

    protected Application $application;

    protected function setUp(): void {
        $runner = $this->createMock(ShellRunner::class);
        $runner->method('exec')
            ->willReturnCallback(function ($cmd, &$output, &$exitCode) {
                $output = ['Mocked .mo generation'];
                $exitCode = 0;
            });

        $command = new MakeMoCommand($runner);

        $this->application = new Application();
        $this->application->setAutoExit(false); // Important for tests
        $this->application->add($command);
    }

    public function testCommandIsRegisteredAndConfigured(): void {
        $command = $this->application->find( 'i18n:make-mo' );

        $this->assertSame( 'i18n:make-mo', $command->getName() );
        $this->assertNotEmpty( $command->getDescription() );
        $this->assertNotEmpty( $command->getHelp() );
    }
}
