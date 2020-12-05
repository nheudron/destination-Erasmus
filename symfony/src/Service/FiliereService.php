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
    public function getAllBranches(): iterable
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getBranchByName(string $name): Filiere
    {
        /** @var Filiere|null $oneBranch */
        $oneBranch = $this->getRepo()->findOneBy(["name"=>$name]);
        if ($oneBranch == null) throw new NotFoundHttpException("No branch found");
        return $oneBranch;
    }
    /**
     * @inheritDoc
     */
    public function getBranchById(int $branchId): Filiere
    {
        /** @var Filiere|null $oneBranch */
        $oneBranch = $this->getRepo()->find($branchId);
        if ($oneBranch == null) throw new NotFoundHttpException("No branch found");
        return $oneBranch;
    }
}