<?php

namespace GestoriaBundle\Datafixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GestoriaBundle\Entity\User;

class LoadAdminData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $admin->setName('Super Administrador');
        $admin->setLastName('del Sistema');
        $admin->setEmail('naarnet10@gmail.com');
        $admin->setPassword('ronaldinho');
        $admin->addRole($this->getReference('ROLE_ADMIN'));
        

        $this->addReference('admin', $admin);

        $manager->persist($admin);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

//put your code here
}
