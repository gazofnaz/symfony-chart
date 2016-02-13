<?php

use AppBundle\Command\GuardianFetchCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class GuardianFetchCommandTest
 *
 * Behavioral tests for the command. Must extend KernelTestCase so we don't have to mock the whole world
 *
 */
class GuardianFetchCommandTest extends KernelTestCase
{
    /**
     * Test the command fails as expected when no username is passed
     */
    public function testExecuteWithEmptyUsername(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application( $kernel );
        $application->add( new GuardianFetchCommand() );

        $command = $application->find( 'app:guardian:fetch' );
        $commandTester = new CommandTester( $command );

        $this->setExpectedException( 'Symfony\Component\Console\Exception\RuntimeException', 'Not enough arguments (missing: "username").' );

        $commandTester->execute(array( 'command' => $command->getName() ) );

    }

    /**
     * Test the command fails as expected when a username which does not exist in the database is passed
     */
    public function testExecuteWithInvalidUsername(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application( $kernel );
        $application->add( new GuardianFetchCommand() );

        $command = $application->find( 'app:guardian:fetch' );
        $commandTester = new CommandTester( $command );

        $this->setExpectedException( 'AppBundle\Exception\UserNotFoundException', 'User with username: xxxyyyzzz could not be found in the database' );

        $commandTester->execute(
            array(
                'command'      => $command->getName(),
                'username'     => 'xxxyyyzzz'
            ));

    }

    /**
     * Test the command gives expected output when a valid username is passed
     */
    public function testExecuteWithValidUsername(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application( $kernel );
        $application->add( new GuardianFetchCommand() );

        $command = $application->find( 'app:guardian:fetch' );
        $commandTester = new CommandTester( $command );

        $commandTester->execute(
            array(
                'command'      => $command->getName(),
                'username'     => 'user0'
            ));

        $this->assertRegExp( '/Starting fetch for user\: user0/', $commandTester->getDisplay(), 'Fetched user details may be incorrect' );
    }
}