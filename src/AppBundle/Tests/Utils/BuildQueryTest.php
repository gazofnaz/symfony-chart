<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\BuildQuery;

/**
 * More of a suite of functional tests than unit tests
 *
 * BDD is not practical because this code is never rendered
 *
 * Class BuildQueryTest
 * @package AppBundle\Tests\Utils
 */
class BuildQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $container;

    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $logger;

    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $user;

    public function setUp(){
        $this->container = $this->getMock( '\\Symfony\\Component\\DependencyInjection\\ContainerInterface' );
        $this->logger = $this->getMockBuilder( '\\Monolog\\Logger' )
                       ->disableOriginalConstructor()
                       ->getMock();
        $this->user = $this->getMock( '\\AppBundle\\Entity\User' );
    }

    /**
     * Tests that the ParameterBag array has the expected keys, and is the correct class type
     *
     * array(
     *    q'        => 'firstName',
     *    key'      => 'xxx' ,
     *    order-by' => 'new' ,
     *
     * )
     */
    public function testBuildQueryForUserKeysExist()
    {

        $query = new BuildQuery( $this->container,  $this->logger );

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will( $this->returnValue( 'RandomFirstName' ) );

        $queryParameters = $query->buildQueryForUser( $this->user );

        $this->assertInstanceOf( "\Symfony\Component\DependencyInjection\ParameterBag\ParameterBag", $queryParameters );

        $this->assertTrue( $queryParameters->has( 'api-url' ), 'Parameter with key api-url does not exist' );
        $this->assertTrue( $queryParameters->has( 'api-key' ), 'Parameter with key api-key does not exist' );
        $this->assertTrue( $queryParameters->has( 'q' ), 'Parameter with key q does not exist' );
        $this->assertTrue( $queryParameters->has( 'order-by' ), 'Parameter with key order-by does not exist' );

    }

    /**
     * Test to assert that the username is not set to an empty string
     */
    public function testBuildQueryForUserWithEmptyName(){

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will( $this->returnValue( '' ) );

        $query = new BuildQuery( $this->container,  $this->logger );

        $this->setExpectedException( '\AppBundle\Exception\EmptyNameException', 'The First Name cannot be empty' );

        $resultArray = $query->buildQueryForUser( $this->user );

    }

    /**
     * Test to assert that the username is not set to null
     */
    public function testBuildQueryForUserWithNullName(){

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will( $this->returnValue( null ) );

        $query = new BuildQuery( $this->container,  $this->logger );

        $this->setExpectedException( '\AppBundle\Exception\EmptyNameException', 'The First Name cannot be empty' );

        $resultArray = $query->buildQueryForUser( $this->user );

    }

}