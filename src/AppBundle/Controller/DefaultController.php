<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route( "/", name="homepage" )
     */
    public function indexAction()
    {
        // @todo split by first name
        $data = $this->getDoctrine()
                     ->getRepository( 'AppBundle:Data' )
                     ->findAll();

        // warning, json_encode manipulates the data.
        return $this->render(
            'default/index.html.twig',
            array( 'data' => json_encode( $data ) )
        );
    }

}
