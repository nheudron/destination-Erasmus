<?php

namespace App\Service;

use App\Entity\Universities;
use Doctrine\ORM\Query;

interface IUniversityService
{
    /**
     * @return iterable
     */
    public function getAllUniv() : iterable;

    /**
     * @inheritDoc
     */
    public function getAllUnivAlphaOrder(): iterable;

    /**
     * @return Query
     */
    public function getAllUnivByQuery(): Query;

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