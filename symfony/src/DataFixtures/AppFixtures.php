<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use App\Entity\Universities;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /** @var string */
    private $environment;
    /** @var EntityManager */
    private $em;
    /** @var ContainerInterface */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $kernel = $this->container->get('kernel');
        if ($kernel) $this->environment = $kernel->getEnvironment();
    }

    public function load(ObjectManager $manager)
    {
        $this->em = $manager;

        $stackLogger = new DebugStack();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($stackLogger);

        //  UNIVERSITY

        $univ1 = new Universities();
        $univ1->setName("Obuda University");
        $univ1->setAvailablePlaces(12);
        $univ1->setFavorites(5);
        $univ1->setLanguage("LV1");
        $this->em->persist($univ1);

        $univ2 = new Universities();
        $univ2->setName("Super university");
        $univ2->setAvailablePlaces(3);
        $univ2->setFavorites(162);
        $univ2->setLanguage("LV1");
        $this->em->persist($univ2);

        for($i = 1; $i <= 5; $i++){
            $univ = new Universities();
            $univ -> setName("université $i");
            $univ -> setAvailablePlaces("$i");
            $univ -> setFavorites("$i");
            $univ -> setLanguage("LV2");
            $this->em->persist($univ);
        }
        
        //  USER

        $user = new Users();
        $user->setEmail("test@esaip.org");
        $user->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $user->setLastName("Poisson");
        $user->setFirstName("Nicolas");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->addFavorite($univ1);
        $user->addFavorite($univ2);
        $this->em->persist($user);
        // Filière

        $filiere = new Filiere();
        $filiere->setName("Big-Data");
        $this->em->persist($filiere);

        $this->em->flush();

        echo "QUERIES: ".count($stackLogger->queries)."\n"; //numbers of queries (persists)
    }
}
