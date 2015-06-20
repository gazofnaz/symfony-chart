<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
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

    public function buildQuery( User $user ){

        $query = array(
            'query' => array()
        );

        return $query;
    }

    public function getResponse(){

    }
}