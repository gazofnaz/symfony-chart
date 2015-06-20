<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
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
        $container = $this->getMock( '\\Symfony\\Component\\DependencyInjection\\ContainerInterface' );
        $logger = $this->getMockBuilder( '\\Monolog\\Logger' )
            ->disableOriginalConstructor()
            ->getMock();
        $user = $this->getMock( '\\AppBundle\\Entity\User' );
        $user
            ->expects( $this->any() )
            ->method( 'getFirstName' )
            ->will($this->returnValue( 'Gareth' ));

        $query = new Query( $container,  $logger );

        $resultArray = $query->buildQuery( $user );

        $this->assertArrayHasKey( 'query'   , $resultArray );
        $this->assertArrayHasKey( 'q'       , $resultArray['query'] );
        $this->assertArrayHasKey( 'key'     , $resultArray['query'] );
        $this->assertArrayHasKey( 'order-by', $resultArray['query'] );


    }
}