<?php
namespace AppBundle\Utils;

use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Guzzle\Http\Client;

class RunQuery
{

    /** @var ContainerInterface $container */
    private $container;

    /** @var Logger $logger */
    private $logger;

    public function __construct(
        ContainerInterface $container,
        Logger $logger
    ){
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * @param ParameterBag $queryParameters
     * @return string
     * @throws \Exception
     */
    public function getResponse( ParameterBag $queryParameters ){

        if( $queryParameters->has( 'api-url')  === false ){
            throw new \Exception( 'api-url parameter could not be found. Please check your configuration' );
        }

        $client = new Client();

        $query = '';
        return $query;
    }
}