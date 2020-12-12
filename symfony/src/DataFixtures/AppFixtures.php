<?php

namespace App\DataFixtures;

use App\Entity\Cities;
use App\Entity\Countries;
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

        //  COUNTRY

        $country1 = new Countries();
        $country1->setName("Hungary");
        $country1->setCurrency("Forint");
        $country1->setLanguage("Magyar");
        $this->em->persist($country1);

        $country2 = new Countries();
        $country2->setName("Super Country");
        $country2->setCurrency("SuperDollar");
        $country2->setLanguage("Super tongue");
        $this->em->persist($country2);

        $country = new Countries();
        $country->setName("Lambda");
        $country->setCurrency("Lambda Dollar");
        $country->setLanguage("Lambdalala");
        $this->em->persist($country);

        //  CITY

        $city1 = new Cities();
        $city1->setName("Budapest");
        $city1->setCityCountry($country1);
        $city1->setInhabitants("1700000");
        $city1->setPresentation("Charmante ville wsh");
        $this->em->persist($city1);

        $city2 = new Cities();
        $city2->setName("Super City");
        $city2->setCityCountry($country2);
        $city2->setInhabitants("10000000");
        $city2->setPresentation("Super ville wsh");
        $this->em->persist($city2);

        $city = new Cities();
        $city->setName("lambdaTown");
        $city->setCityCountry($country);
        $city->setInhabitants("1");
        $city->setPresentation("ville lambda");
        $this->em->persist($city);

        //  UNIVERSITY

        $univ1 = new Universities();
        $univ1->setName("Obuda University");
        $univ1->setAvailablePlaces(12);
        $univ1->setFavorites(5);
        $univ1->setLanguage("LV1");
        $univ1->setUnivCity($city1);
        $this->em->persist($univ1);

        $univ2 = new Universities();
        $univ2->setName("Super university");
        $univ2->setAvailablePlaces(3);
        $univ2->setFavorites(162);
        $univ2->setLanguage("LV1");
        $univ2->setUnivCity($city2);
        $this->em->persist($univ2);

        for($i = 1; $i <= 5; $i++){
            $univ = new Universities();
            $univ->setName("université $i");
            $univ->setAvailablePlaces("$i");
            $univ->setFavorites("$i");
            $univ->setLanguage("LV2");
            $univ->setUnivCity($city);
            $this->em->persist($univ);
        }
        
        //  USER

        $user = new Users();
        $user->setEmail("test@esaip.org");
        $user->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $user->setLastName("Poisson");
        $user->setFirstName("Nicolas");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->toggleFav($univ1);
        $user->toggleFav($univ2);
        $this->em->persist($user);

        $user2 = new Users();
        $user2->setEmail("user@esaip.org");
        $user2->setFirstName("Regular");
        $user2->setLastName("User");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user2);
        // Filière

        $filiere = new Filiere();
        $filiere1 = new Filiere();
        $filiere2 = new Filiere();
        $filiere3 = new Filiere();
        $filiere4 = new Filiere();
        $filiere5 = new Filiere();
        $filiere6 = new Filiere();
        $filiere7 = new Filiere();
        $filiere->setName("Big-Data");
        $filiere1->setName("Transition du numérique");
        $filiere2->setName("Cybersécurité");
        $filiere3->setName("IOT");
        $filiere4->setName("Environnement");
        $filiere5->setName("Energie");
        $filiere6->setName("QHSE");
        $filiere7->setName("Gestion des risques");
        $this->em->persist($filiere);
        $this->em->persist($filiere1);
        $this->em->persist($filiere2);
        $this->em->persist($filiere3);
        $this->em->persist($filiere4);
        $this->em->persist($filiere5);
        $this->em->persist($filiere6);
        $this->em->persist($filiere7);

        $this->em->flush();

        echo "QUERIES: ".count($stackLogger->queries)."\n"; //numbers of queries (persists)
    }
}
