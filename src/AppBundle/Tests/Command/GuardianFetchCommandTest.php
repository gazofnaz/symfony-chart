<?php

use AppBundle\Command\GuardianFetchCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class GuardianFetchCommandTest
 *
 * Behavioral tests for the command.
 *
 */
class GuardianFetchCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteWithEmptyUsername(){
        $application = new Application();
        $application->add( new GuardianFetchCommand() );

        $command = $application->find( 'app:guardian:fetch' );
        $commandTester = new CommandTester( $command );

        $this->setExpectedException( 'Symfony\Component\Console\Exception\RuntimeException', 'Not enough arguments (missing: "username").' );

        $commandTester->execute(array( 'command' => $command->getName() ) );

    }
}