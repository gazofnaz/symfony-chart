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

    public function setUp(){
        $this->container = $this->getMock( '\\Symfony\\Component\\DependencyInjection\\ContainerInterface' );
        $this->logger = $this->getMockBuilder( '\\Monolog\\Logger' )
                       ->disableOriginalConstructor()
                       ->getMock();
    }


}