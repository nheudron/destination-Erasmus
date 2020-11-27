<?php

namespace App\Service;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityService
{
    /** @var UserPasswordEncoderInterface */
    private $em;
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function registerUser(string $email, string $clearPass, string $firstName, string $lastName) : void
    {
        $user = new Users();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->encoder->encodePassword($user, $clearPass));
        $this->em->persist($user);
        $this->em->flush();
    }

    public function checkPassword(string $mail, string $clearPass) : bool
    {
        /** @var Users $user */
        $user = $this->findUserByMail($mail);
        return $this->isPasswordValid($user, $clearPass);
    }

    public function findUserByMail(string $mail) : ?Users
    {
        return $this->em->getRepository(Users::class)->findOneBy(["email"=>$mail]);
    }

    public function isPasswordValid(?UserInterface $user, string $clearPass)
    {
        if (!$user) return false;
        return $this->encoder->isPasswordValid($user, $clearPass);
    }
}