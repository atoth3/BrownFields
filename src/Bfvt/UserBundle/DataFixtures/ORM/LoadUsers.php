<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Bfvt\UserBundle\DataFixtures\ORM;

use Bfvt\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('adamkempo');
        $user->setPassword($this->encodePassword($user, '12345'));
        $manager->persist($user);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }

    private function encodePassword(User $user, $plainTextPassword){
        $encoder = $this->container->get('security.password_encoder');

        return $encoder->encodePassword($user, $plainTextPassword);
    }
}