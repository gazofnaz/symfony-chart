<?php

namespace AppBundle\Command;

use Guzzle\Http\Exception\RequestException;
use Guzzle\Service\Client;
use Psr\Log\LoggerInterface;
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
                 'userId',
                 InputArgument::REQUIRED,
                 'The Id of the user you wish to fetch data for.' )
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
        /** @var $logger LoggerInterface */
        $logger = $container->get('logger');

        $apiUrl = $container->getParameter( 'guardian_api.url' );
        $apiSearchPage = $container->getParameter( 'guardian_api.search_page' );
        $apiKey = $container->getParameter( 'guardian_api.key' );

        $apiQueryFieldApiKey = $container->getParameter( 'guardian_api.query_field.api_key' );
        $apiQueryFieldSearch = $container->getParameter( 'guardian_api.query_field.search' );

        $headers = array();

        // @todo buildQuery method
        $query = array(
            'query' =>
                array(
                    $apiQueryFieldApiKey => $apiKey,
                    $apiQueryFieldSearch => 'gareth'
                )
        );

        $client = new Client( $apiUrl );
        $request = $client->get( $apiSearchPage, $headers,  $query );

        // @todo getResponse method
        try{
            $response = $request->send();
            /** @var \Guzzle\Http\EntityBody $body */
            $body = $response->getBody();
            // @todo find out how magic method is used
            $output->writeln( $body->__toString() );
        }
        catch( RequestException $e ){
            $output->writeln( $e->getMessage() );
            $logger->error( $e->getTraceAsString() );
        }
        catch( \Exception $e ){
            $output->writeln( "Unexpected exception: " . $e->getMessage() );
            $logger->error( $e->getTraceAsString() );
        }

    }

}