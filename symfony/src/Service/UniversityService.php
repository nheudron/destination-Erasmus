<?php

namespace App\Service;

use App\Entity\Universities;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UniversityService extends CrudService implements IUniversityService
{
    /**
     * @inheritDoc
     */
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Universities::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllUniv(): iterable
    {
        return $this->getRepo()->findAll();
    }

    public function getAllUnivByQuery(): Query
    {
        return $this
            ->em
            ->createQueryBuilder()
            ->select("universities")
            ->from(Universities::class, "universities")
            ->getQuery();
    }

    /**
     * @inheritDoc
     */
    public function getUnivByName(string $name): Universities
    {
        /** @var Universities|null $oneUniv */
        $oneUniv = $this->getRepo()->findOneBy(["lastName"=>$name]);
        if ($oneUniv == null) throw new NotFoundHttpException("No university found");
        return $oneUniv;
    }

    /**
     * @inheritDoc
     */
    public function getUnivById(int $univId): Universities
    {
        /** @var Universities|null $oneUniv */
        $oneUniv = $this->getRepo()->find($univId);
        if ($oneUniv == null) throw new NotFoundHttpException("No university found");
        return $oneUniv;
    }
}