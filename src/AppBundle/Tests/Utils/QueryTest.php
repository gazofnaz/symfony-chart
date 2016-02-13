<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\Query;

/**
 * More of a suite of functional tests than unit tests
 *
 * BDD is not practical because this code is never rendered
 *
 * Class QueryTest
 * @package AppBundle\Tests\Utils
 */
class QueryTest extends \PHPUnit_Framework_TestCase
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
     * Tests that the multidimensional query array has the expected keys
     *
     * array(
     *     'query' => array(
     *         'q'        => 'firstName',
     *         'key'      => 'xxx' ,
     *         'order-by' => 'new' ,
     *     )
     * )
     */
    public function testBuildQueryForUserKeysExist()
    {

        $query = new Query( $this->container,  $this->logger );

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will( $this->returnValue( 'RandomFirstName' ) );

        $resultArray = $query->buildQueryForUser( $this->user );

        $this->assertArrayHasKey( 'query'   , $resultArray );
        $this->assertInternalType( 'array'  , $resultArray['query'], 'the query subset is not an array' );

        $this->assertArrayHasKey( 'api-url' , $resultArray['query'] );
        $this->assertArrayHasKey( 'api-key' , $resultArray['query'] );
        $this->assertArrayHasKey( 'q'       , $resultArray['query'] );
        $this->assertArrayHasKey( 'order-by', $resultArray['query'] );


    }

    /**
     * Test to assert that the username is not set to an empty string
     */
    public function testBuildQueryForUserWithEmptyName(){

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will( $this->returnValue( '' ) );

        $query = new Query( $this->container,  $this->logger );

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

        $query = new Query( $this->container,  $this->logger );

        $this->setExpectedException( '\AppBundle\Exception\EmptyNameException', 'The First Name cannot be empty' );

        $resultArray = $query->buildQueryForUser( $this->user );

    }

}