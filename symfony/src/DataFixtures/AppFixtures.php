<?php

namespace App\DataFixtures;

use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Majors;
use App\Entity\Subjects;
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
        /*
        $country1 = new Countries();
        $country1->setName("Hungary");
        // $country1->setCurrency("Forint");
        $country1->setLanguage("Magyar");
        $country1->setFlag("https://upload.wikimedia.org/wikipedia/commons/c/c1/Flag_of_Hungary.svg");
        $this->em->persist($country1);

        $country2 = new Countries();
        $country2->setName("Super Country");
        // $country2->setCurrency("SuperDollar");
        $country2->setLanguage("Super tongue");
        $country2->setFlag("https://upload.wikimedia.org/wikipedia/en/c/c3/Flag_of_France.svg");
        $this->em->persist($country2);

        $country = new Countries();
        $country->setName("Lambda");
        // $country->setCurrency("Lambda Dollar");
        $country->setLanguage("Lambdalala");
        $country->setFlag("https://upload.wikimedia.org/wikipedia/commons/f/fe/Flag_of_C%C3%B4te_d%27Ivoire.svg");
        $this->em->persist($country);

        //  CITY

        $city1 = new Cities();
        $city1->setName("Budapest");
        $city1->setCityCountry($country1);
        // $city1->setInhabitants("1700000");
        $city1->setPresentation("Charmante ville wsh");
        $this->em->persist($city1);

        $city2 = new Cities();
        $city2->setName("Super City");
        $city2->setCityCountry($country2);
        // $city2->setInhabitants("10000000");
        $city2->setPresentation("Super ville wsh");
        $this->em->persist($city2);

        $city = new Cities();
        $city->setName("lambdaTown");
        $city->setCityCountry($country);
        // $city->setInhabitants("1");
        $city->setPresentation("ville lambda");
        $this->em->persist($city);


        //SUBJECTS

        $subject1 = new Subjects();
        $subject1->setName("Math");
        $subject1->setCredits("6");
        $subject1->setHoursPerWeek("4");
        $this->em->persist($subject1);

        $subject2 = new Subjects();
        $subject2->setName("Anglais");
        $subject2->setCredits("6");
        $subject2->setHoursPerWeek("6");
        $this->em->persist($subject2);

        $subject3 = new Subjects();
        $subject3->setName("Développement");
        $subject3->setCredits("6");
        $subject3->setHoursPerWeek("8");
        $this->em->persist($subject3);

        // Filière
        $major = new Majors();
        $major1 = new Majors();
        $major2 = new Majors();
        $major3 = new Majors();
        $major4 = new Majors();
        $major5 = new Majors();
        $major6 = new Majors();
        $major7 = new Majors();
        $major->setName("Big-Data");
        $major1->setName("Transition du numérique");
        $major2->setName("Cybersécurité");
        $major3->setName("IOT");
        $major4->setName("Environnement");
        $major5->setName("Energie");
        $major6->setName("QHSE");
        $major7->setName("Gestion des risques");
        $major->setBranch("IR");
        $major1->setBranch("IR");
        $major2->setBranch("IR");
        $major3->setBranch("IR");
        $major4->setBranch("SEP");
        $major5->setBranch("SEP");
        $major6->setBranch("SEP");
        $major7->setBranch("SEP");
        $this->em->persist($major);
        $this->em->persist($major1);
        $this->em->persist($major2);
        $this->em->persist($major3);
        $this->em->persist($major4);
        $this->em->persist($major5);
        $this->em->persist($major6);
        $this->em->persist($major7);

        //  UNIVERSITY
        $univ1 = new Universities();
        $univ1->setName("Obuda University");
        $univ1->setAvailablePlaces(12);
        $univ1->setLanguage("Anglais");
        $univ1->setUnivCity($city1);
        $univ1->addSubject($subject1);
        $univ1->addSubject($subject2);
        $univ1->addSubject($subject3);
        $univ1->setLat(-39.90261);
        $univ1->setLon(-69.69234);
        $univ1->addMajor($major2);
        $univ1->addMajor($major5);
        $this->em->persist($univ1);

        $univ2 = new Universities();
        $univ2->setName("Super university");
        $univ2->setAvailablePlaces(3);
        $univ2->setLanguage("Espagnol");
        $univ2->setUnivCity($city2);
        $univ2->addSubject($subject1);
        $univ2->addSubject($subject3);
        $univ2->setLat(-19.92056);
        $univ2->setLon(144.36009);
        $univ2->addMajor($major2);
        $univ2->addMajor($major1);
        $this->em->persist($univ2);

        for($i = 1; $i <= 5; $i++){
            $univ = new Universities();
            $univ->setName("université $i");
            $univ->setAvailablePlaces("$i");
            $univ->setLanguage("Allemand");
            $univ->setUnivCity($city);
            $univ->addSubject($subject2);
            $univ->addSubject($subject3);
            $univ->setLat(46.13224);
            $univ->setLon(132.71830);
            $univ->addMajor($major6);
            $univ->addMajor($major5);
            $this->em->persist($univ);
        }*/
        
        //  USER

        $user = new Users();
        $user->setEmail("test@esaip.org");
        $user->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $user->setLastName("Test");
        $user->setFirstName("Test");
        $user->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($user);

        $user2 = new Users();
        $user2->setEmail("user@esaip.org");
        $user2->setFirstName("Regular");
        $user2->setLastName("User");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user2);

        $user3 = new Users();
        $user3->setEmail("nheudron.ir2022@esaip.org");
        $user3->setFirstName("Nicolas");
        $user3->setLastName("Heudron");
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user3);

        $user4 = new Users();
        $user4->setEmail("ljolly.ing2022@esaip.org");
        $user4->setFirstName("Léonie");
        $user4->setLastName("Jolly");
        $user4->setRoles(["ROLE_USER"]);
        $user4->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user4);

        $user5 = new Users();
        $user5->setEmail("npoisson.ing2022@esaip.org");
        $user5->setFirstName("Nicolas");
        $user5->setLastName("Poisson");
        $user5->setRoles(["ROLE_USER"]);
        $user5->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user5);

        $user6 = new Users();
        $user6->setEmail("fchataigner.ing2022@esaip.org");
        $user6->setFirstName("Firmin");
        $user6->setLastName("Chataigner");
        $user6->setRoles(["ROLE_USER"]);
        $user6->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user6);

        $user7 = new Users();
        $user7->setEmail("bde.angers@esaip.org");
        $user7->setFirstName("BDE");
        $user7->setLastName("Admin");
        $user7->setRoles(["ROLE_ADMIN"]);
        $user7->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user7);

        $user8 = new Users();
        $user8->setEmail("admin@esaip.org");
        $user8->setFirstName("Admin");
        $user8->setLastName("ESAIP");
        $user8->setRoles(["ROLE_ADMIN"]);
        $user8->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user8);

        /*
        $univ1->addMajor($major6);
        $univ1->addContributor($user);
        $univ1->addContributor($user2);
        $univ1->addContributor($user3);
        $this->em->persist($univ1);

        $univ2->addMajor($major3);
        $univ2->addContributor($user);
        $univ2->addContributor($user2);
        $univ2->addContributor($user3);
        $this->em->persist($univ2);
        */

        $this->em->flush();

        echo "QUERIES: ".count($stackLogger->queries)."\n"; //numbers of queries (persists)
    }
}
