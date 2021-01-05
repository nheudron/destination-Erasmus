<?php

namespace App\Service;

use App\Entity\Majors;

interface IFiliereService
{
    /**
     * @return Majors[]|iterable
     */
    public function getAllBranches() : iterable;

    /**
     * @param string $name
     * @return Majors
     */
    public function getBranchByName(string $name): Majors;

    /**
     * @param int $branchId
     * @return Majors
     */
    public function getBranchById(int $branchId): Majors;
}