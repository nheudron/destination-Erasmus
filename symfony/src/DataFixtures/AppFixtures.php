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
    
        //  USER

        $user = new Users();
        $user->setEmail("test@esaip.org");
        $user->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $user->setLastName("Poisson");
        $user->setFirstName("Nicolas");
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
        $user3->setEmail("nheudron@esaip.org");
        $user3->setFirstName("Nicolas");
        $user3->setLastName("Heudron");
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword(password_hash("c",PASSWORD_DEFAULT));
        $this->em->persist($user3);

        $this->em->flush();

        echo "QUERIES: ".count($stackLogger->queries)."\n"; //numbers of queries (persists)
    }
}
