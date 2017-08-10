<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadRoleData
 *
 * @author root
 */

namespace GestoriaBundle\Datafixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GestoriaBundle\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {

        //Administrador general de TANTAN
        $roleAdmin = new Role();
        $roleAdmin->setName('ROLE_ADMIN');
        $roleAdmin->setAlias('ADMINISTRADOR');
        $roleAdmin->setDescription('ADMINISTRADOR GENERAL DE GESTIRUA');
        $manager->persist($roleAdmin);
        $this->addReference('ROLE_ADMIN', $roleAdmin);

        $manager->flush();
    }

}
