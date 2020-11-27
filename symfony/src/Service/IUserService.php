<?php

namespace App\Service;

use App\Entity\Users;

interface IUserService
{
    /**
     * @return Users[]|iterable
     */
    public function getAllUsers() : iterable;

    /**
     * @param string $lastName
     * @return Users
     */
    public function getUserByLastName(string $lastName): Users;

    /**
     * @param int $userId
     * @return Users
     */
    public function getUserById(int $userId): Users;

    /**
     * @param string $mail
     * @return Users
     */
    public function getUserByMail(string $mail): Users;
}