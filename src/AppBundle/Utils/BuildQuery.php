<?php
namespace AppBundle\Utils;

use AppBundle\Entity\User;
use AppBundle\Exception\EmptyNameException;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class BuildQuery
{
    /**
     * These are the key names as required by the api
     */
    const API_URL       = 'api-url';
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
     * @return ParameterBag
     * @throws EmptyNameException
     */
    public function buildQueryForUser( User $user ){

        /** @throws \InvalidArgumentException */
        $key = $this->container->getParameter( 'guardian_api.key' );
        $apiUrl = $this->container->getParameter( 'guardian_api.url' );

        $firstName = $user->getFirstName();

        if( $firstName == null | $firstName == '' ){
            throw new EmptyNameException( 'The First Name cannot be empty' );
        }

        /** @throws \InvalidArgumentException */
        $orderBy = $this->container->getParameter( 'guardian_api.order_by' );

        $query = new ParameterBag(
            array (
                self::API_URL       => $apiUrl,
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