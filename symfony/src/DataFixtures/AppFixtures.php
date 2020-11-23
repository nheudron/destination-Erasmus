<?php

namespace App\DataFixtures;

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
        $user->setPassword(password_hash("motdepasse",PASSWORD_DEFAULT));
        $user->setLastName("Poisson");
        $user->setFirstName("Nicolas");
        $user->setRoles(["ROLE_ADMIN"]);
        $this->em->persist($user);

        $this->em->flush();

        echo "QUERIES: ".count($stackLogger->queries)."\n"; //numbers of queries (persists)
    }
}
