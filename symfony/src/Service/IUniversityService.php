<?php

namespace App\Service;

use App\Entity\Universities;

interface IUniversityService
{
    /**
     * @return Universities[]|iterable
     */
    public function getAllUniv() : iterable;

    /**
     * @param string $name
     * @return Universities
     */
    public function getUnivByName(string $name): Universities;

    /**
     * @param int $univId
     * @return Universities
     */
    public function getUnivById(int $univId): Universities;
}