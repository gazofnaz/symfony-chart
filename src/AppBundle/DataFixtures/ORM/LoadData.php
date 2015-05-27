<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Data;

class LoadData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load( ObjectManager $manager )
    {
        foreach( ['2010', '2011', '2012', '2013', '2014', '2015'] as $key => $year ){

            $user = new User();
            $data = new Data();

            $user->setUsername( "user$key" );
            $user->setPassword( "user$key" );
            $user->setFirstName( "user$key" );

            $data->setCount( rand( 1, 100 ) );
            $data->setDate( mktime(0, 0, 0, 12, 31, $year) );
            $data->setUser( $user );

            $manager->persist( $user );
            $manager->persist( $data );
            $manager->flush();
        }
    }
}