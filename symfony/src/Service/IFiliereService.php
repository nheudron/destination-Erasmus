<?php

namespace App\Service;

use App\Entity\Filiere;

interface IFiliereService
{
    /**
     * @return Filiere[]|iterable
     */
    public function getAllFilieres() : iterable;

    /**
     * @param string $name
     * @return Filiere
     */
    public function getFiliereByName(string $name): Filiere;

    /**
     * @param int $filiereId
     * @return Filiere
     */
    public function getFiliereById(int $filiereId): Filiere;
}