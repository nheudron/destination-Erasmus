<?php

namespace App\Service;

use App\Data\SearchData;
use App\Entity\Universities;
use App\Entity\Majors;
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

      /*
    * réupère les universités en lien avec une recherche
    * @return Universities[]
    */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->em
            ->createQueryBuilder()
            ->select("universities", "Majors")
            ->from(Universities::class, "universities")
            ->join('universities.majors', 'Majors')
            ;

            if($search->filiere == "all"){
                $filiere = '';
            }else{
                $filiere = $search->filiere;
            }

            if(!empty($filiere)){
                $query = $query
                    ->andWhere('Majors.branch LIKE :filiere')
                    ->setParameter('filiere', "%{$search->filiere}%");
            }

            if($search->majeure == ""){
                $majeure = '';
            }else{
                $majeure = $search->majeure;
            }

            if(!empty($majeure)){
                $query = $query
                    ->andWhere('Majors.name LIKE :majeure')
                    ->setParameter('majeure', "%{$search->majeure}%");
            }

            if($search->langue == ""){
                $langue = '';
            }else{
                $langue = $search->langue;
            }

            if(!empty($langue)){
                $query = $query
                    ->andWhere('universities.language LIKE :langue')
                    ->setParameter('langue', "%{$search->langue}%");
            }

        return $query->getQuery()->getResult();
    }
}