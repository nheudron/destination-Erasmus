<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\IUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationerasmusController extends AbstractController
{
    /** @var IUserService */
    private $userService;

    public function __construct
    (
        IUserService $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/destinationerasmus", name="destinationerasmus")
     */
    public function index(): Response
    {
        return $this->render('destinationerasmus/index.html.twig', [
            'controller_name' => 'DestinationerasmusController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('destinationerasmus/home.html.twig');
    }

    /**
     * @Route("/destination", name="dest")
     */
    public function dest(){
        return $this->render('destinationerasmus/dest.html.twig');
    }

    /**
     * @Route("/user", name="userPage")
     */
    public function user(){
        $user = $this->userService->getUserByMail($this->getUser()->getUsername());

        return $this->render('destinationerasmus/user.html.twig', [
            'user'=>$user
        ]);
    }
}
