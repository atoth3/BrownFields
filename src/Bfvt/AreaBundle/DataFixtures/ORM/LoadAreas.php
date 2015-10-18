<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Bfvt\AreaBundle\DataFixtures\ORM;

use Bfvt\AreaBundle\Entity\Area;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEvents implements FixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $area1 = new Area();
        $area1->setName('Nagymaros Vegymu');
        $area1->setLocation('Nagymaros');
        $area1->setDate(new \DateTime('tomorrow noon'));
        $area1->getDetails('Ez a legnagyobb a kornyeken');
        $manager->persist($area1);

        $area2 = new Area();
        $area2->setName('Kismaros Egeto');
        $area2->setLocation('Kismaros');
        $area2->setDate(new \DateTime('today noon'));
        $area2->getDetails('Ez a legszebb a kornyeken');
        $manager->persist($area2);

        $manager->flush();
    }
}