<?php

namespace App\Service;

use App\Entity\Filiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FiliereService extends CrudService implements IFiliereService
{
    /**
     * @inheritDoc
     */
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Filiere::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllFilieres(): iterable
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getFiliereByName(string $name): Filiere
    {
        /** @var Filiere|null $oneFiliere */
        $oneFiliere = $this->getRepo()->findOneBy(["name"=>$name]);
        if ($oneFiliere == null) throw new NotFoundHttpException("No filière found");
        return $oneFiliere;
    }
    /**
     * @inheritDoc
     */
    public function getFiliereById(int $id): Filiere
    {
        /** 
         * @var Filiere|null $oneUser 
         */
        $oneFiliere = $this->getRepo()->find($id);
        if ($oneFiliere == null) throw new NotFoundHttpException("No filière found");
        return $oneFiliere;
    }
}