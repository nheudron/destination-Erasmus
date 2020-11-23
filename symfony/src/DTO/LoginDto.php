<?php
/**
 * Created by Nicolas Poisson.
 * User: anon
 * Date: 2020. 11. 23.
 * Time: 16:32
 */

namespace App\DTO;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class LoginDto extends DtoBase
{
    /** @var string */
    private $mail = "";

    /** @var string */
    private $userPass = "";

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getUserPass(): string
    {
        return $this->userPass;
    }

    /**
     * @param string $userPass
     */
    public function setUserPass(string $userPass): void
    {
        $this->userPass = $userPass;
    }

    public function __construct(FormFactoryInterface $formFactory, Request $request)
    {
        parent::__construct($formFactory, $request);
    }

    public function getForm(): FormInterface
    {
        $builder = $this->formFactory->createBuilder(FormType::class, $this);
        $builder->add("mail", TextType::class, ["label"=>"Email"]);
        $builder->add("userPass", PasswordType::class, ["label"=>"Password"]);
        $builder->add("Login", SubmitType::class);
        return $builder->getForm();
    }
}