<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Query
{
    /**
     * As per Symfony best practices, parameters which will almost never
     * change should be class constants and not yml parameters
     */
    const API_KEY       = 'api-key';
    const ORDER_BY      = 'order-by';
    const SEARCH_QUERY  = 'q';
    const START_DATE    = 'from-date';
    const END_DATE      = 'to-date';
    const PAGE_NUMBER   = 'page';
    const PAGE_SIZE     = 'page-size';

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
     * @param User $user
     * @return array
     */
    public function buildQuery( User $user ){

        /** @throws \InvalidArgumentException */
        $key = $this->container->getParameter( 'guardian_api.key' );

        // @todo throw exception for empty name
        $firstName = $user->getFirstName();

        /** @throws \InvalidArgumentException */
        $orderBy = $this->container->getParameter( 'guardian_api.order_by' );

        $query = array(
            'query' => array(
                self::API_KEY       => $key,
                self::SEARCH_QUERY  => $firstName,
                self::ORDER_BY      => $orderBy
            )
        );

        return $query;
    }

    public function getResponse(){

    }
}