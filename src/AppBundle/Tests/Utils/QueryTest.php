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
    public function testBuildQueryKeysExist()
    {

        $query = new Query( $this->container,  $this->logger );

        $resultArray = $query->buildQuery( $this->user );

        $this->assertArrayHasKey( 'query'   , $resultArray );
        $this->assertInternalType( 'array'  , $resultArray['query'], 'the query subset is not an array' );

        $this->assertArrayHasKey( 'api-key' , $resultArray['query'] );
        $this->assertArrayHasKey( 'q'       , $resultArray['query'] );
        $this->assertArrayHasKey( 'order-by', $resultArray['query'] );


    }

    /**
     * After we've confirmed the keys exist, we check the values of the keys.
     *
     * We don't want to check against our stored parameters because we might accidentally
     * change one resulting in an application failure.
     *
     * @todo this isn't actually testing anything, because everything is being mocked... need to get real data from the container
     *
     * @depends testBuildQueryKeysExist
     */
    public function testBuildQueryKeyValues()
    {
        $map = array(
            array( 'guardian_api.key'     , 'q5kmfff8753v6q2kfq7m3rgu' ),
            array( 'guardian_api.order_by', 'new' )
        );

        $this->container->expects( $this->any() )
                  ->method( 'getParameter' )
                  ->will( $this->returnValueMap( $map ) );

        $this->user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will($this->returnValue( 'Gareth' ));

        $query = new Query( $this->container,  $this->logger );

        $resultArray = $query->buildQuery( $this->user );

        $expectedSubset = array(
            'api-key'       => $this->container->getParameter( 'guardian_api.key' ),
            'q'             => $this->user->getFirstName(),
            'order-by'      => $this->container->getParameter( 'guardian_api.order_by' )
            );

        $this->assertArraySubset( $resultArray['query'],  $expectedSubset );

    }
}