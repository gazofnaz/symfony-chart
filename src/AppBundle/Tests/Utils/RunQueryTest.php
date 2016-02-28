<?php

namespace AppBundle\Tests\Utils;

use AppBundle\Utils\RunQuery;

/**
 * Class RunQueryTest
 * @package AppBundle\Tests\Utils
 */
class RunQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $container;

    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $logger;

    /** @var  \PHPUnit_Framework_MockObject_MockObject $container */
    private $queryParameters;

    public function setUp(){
        $this->container = $this->getMock( '\\Symfony\\Component\\DependencyInjection\\ContainerInterface' );
        $this->logger = $this->getMockBuilder( '\\Monolog\\Logger' )
                       ->disableOriginalConstructor()
                       ->getMock();
        $this->queryParameters = $this->getMock( '\\Symfony\\Component\\DependencyInjection\\ParameterBag\\ParameterBag' );
    }

    /**
     * Test for missing api-url parameter
     *
     * @throws \Exception
     */
    public function testGetResponseWithEmptyApiUrl(){

        $runQueryService = new RunQuery( $this->container,  $this->logger );

        $this->queryParameters
            ->expects( $this->any() )
            ->method( 'has' )
            ->with( 'api-url' )
            ->will( $this->returnValue( false ) );

        $this->setExpectedException( '\Exception', 'api-url parameter could not be found. Please check your configuration' );

        $runQueryService->getResponse( $this->queryParameters );

    }

}