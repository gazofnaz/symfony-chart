<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GuardianFetchCommand
 * @package AppBundle\Command
 */
class GuardianFetchCommand extends ContainerAwareCommand
{
    protected function configure(){

        $this->setName( 'app:guardian:fetch' )
             ->setDescription( 'Perform a fetch of the Guardian API. Searches for the first name of the given userId.' )
             ->addArgument(
                 'username',
                 InputArgument::REQUIRED,
                 'The username (login) of the user you wish to fetch data for.' )
             ->addOption(
                 'startDate',
                 'sd',
                 InputOption::VALUE_OPTIONAL,
                 'The start date for the fetch. Default yesterday.'
             )
             ->addOption(
                 'endDate',
                 'ed',
                 InputOption::VALUE_OPTIONAL,
                 'The end date for the fetch. Default today.'
             );
    }

    protected function execute( InputInterface $input, OutputInterface $output ){

        $container = $this->getContainer();

        /** @var $registry \Doctrine\ORM\EntityManager */
        $entityManager = $container->get( 'doctrine' );

        /** @var \AppBundle\Utils\BuildQuery $queryService */
        $queryService = $container->get( 'app.build_query' );

        /** @var \AppBundle\Utils\Storage $storageService */
        $storageService = $container->get( 'app.storage' );

        $username = $input->getArgument( 'username' );

        // getUser
        $user = $entityManager->getRepository( 'AppBundle:User' )->findOneByUsername( $username );

        // buildQueryForUser
        $query = $queryService->buildQueryForUser( $user );

        dump( $query );
        // getResponse
        // loop appropriately
        // store/process responses
        // report status (how far we got, last date executed, changelog table)

    }

}