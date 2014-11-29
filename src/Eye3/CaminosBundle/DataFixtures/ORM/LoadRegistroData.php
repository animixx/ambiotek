<?php
namespace Eye3\CaminosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Eye3\CaminosBundle\Entity\Registro;

class LoadRegistroData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $creacionAdmin = new Registro();
        $creacionAdmin->setAccion('Creación');
        $creacionAdmin->setUsuario($this->getReference('admin-user'));

        $manager->persist($creacionAdmin);
        $manager->flush();
		
		 $this->addReference('admin-user', $creacionAdmin);
    }
	
	  /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
	
}