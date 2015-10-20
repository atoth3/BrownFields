<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Bfvt\UserBundle\DataFixtures\ORM;

use Bfvt\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $user->setUsername('Seraph');
        $user->setPassword($this->encodePassword($user, '12345'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('adamkempo');
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setPassword($this->encodePassword($admin, '12345'));
        $manager->persist($admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }

    private function encodePassword(User $user, $plainTextPassword){
        $encoder = $this->container->get('security.password_encoder');

        return $encoder->encodePassword($user, $plainTextPassword);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}