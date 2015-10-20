<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Bfvt\AreaBundle\DataFixtures\ORM;

use Bfvt\AreaBundle\Entity\Area;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadEvents implements FixtureInterface, OrderedFixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository('UserBundle:User')
            ->loadUserByUsername('adamkempo');

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

        $area1->setOwner($user);
        $area2->setOwner($user);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}