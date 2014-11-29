<?php
namespace Eye3\CaminosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eye3\CaminosBundle\Entity\Usuario;

class LoadUsuarioData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new Usuario();
        $userAdmin->setNombre('Alexor');
        $userAdmin->setUsername('animix');
        $userAdmin->setPassword('animix');
        $userAdmin->setTipo('ROLE_ADMIN');
        $userAdmin->setGenero(1);
        $userAdmin->setEmail('animix@animix.co');

        $manager->persist($userAdmin);
        $manager->flush();
		
		 $this->addReference('admin-user', $userAdmin);
    }
	
	  /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
	
}