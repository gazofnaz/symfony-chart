<?php
namespace AppBundle\Utils;

use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Query
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

    public function buildQuery(){
    }

    public function getResponse(){

    }
}