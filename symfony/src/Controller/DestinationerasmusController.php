<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationerasmusController extends AbstractController
{
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
}
