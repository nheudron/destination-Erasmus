<?php

namespace App\Service;

use App\Entity\Filiere;

interface IFiliereService
{
    /**
     * @return Filiere[]|iterable
     */
    public function getAllBranches() : iterable;

    /**
     * @param string $name
     * @return Filiere
     */
    public function getBranchByName(string $name): Filiere;

    /**
     * @param int $branchId
     * @return Filiere
     */
    public function getBranchById(int $branchId): Filiere;
}