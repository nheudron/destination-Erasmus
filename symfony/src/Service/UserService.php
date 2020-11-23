<?php

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService extends CrudService implements IUserService
{
    /**
     * @inheritDoc
     */
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Users::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllUsers(): iterable
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getUserByLastName(string $lastName): Users
    {
        /** @var Users|null $oneUser */
        $oneUser = $this->getRepo()->findOneBy(["lastName"=>$lastName]);
        if ($oneUser == null) throw new NotFoundHttpException("No user found");
        return $oneUser;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $userId): Users
    {
        /** @var Users|null $oneUser */
        $oneUser = $this->getRepo()->find($userId);
        if ($oneUser == null) throw new NotFoundHttpException("No user found");
        return $oneUser;
    }

    /**
     * @inheritDoc
     */
    public function getUserByMail(string $mail): Users
    {
        /** @var Users|null $oneUser */
        $oneUser = $this->getRepo()->findOneBy(["email"=>$mail]);
        if ($oneUser == null) throw new NotFoundHttpException("No user found");
        return $oneUser;
    }
}