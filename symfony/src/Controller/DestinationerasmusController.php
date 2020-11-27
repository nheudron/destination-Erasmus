<?php

namespace App\Controller;

use App\Entity\Universities;
use App\Model\UnivListModel;
use App\Service\IUserService;
use App\Service\IUniversityService;
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
    /** @var IUniversityService */
    private $universityService;

    public function __construct
    (
        IUserService $userService,
        IUniversityService $universityService
    )
    {
        $this->userService = $userService;
        $this->universityService = $universityService;
    }

    /**
     * @return Response
     * @Route(path="/destinationErasmus", name="destinationErasmus")
     */
    public function index(): Response
    {
        return $this->render('destinationerasmus/index.html.twig', [
            'controller_name' => 'DestinationErasmusController',
        ]);
    }
    /**
     * @return Response
     * @Route(path="/", name="home")
     */
    public function home(): Response
    {
        /** @var Universities[] $gameList */
        $gameList = $this->universityService->getAllUniv();
        $model = new UnivListModel();
        $model->setUnivList($gameList);

        return $this->render('destinationerasmus/home.html.twig', [
            'model' => $model
        ]);
    }

    /**
     * @param int $univId
     * @return Response
     * @Route(path="/destination/{univId}", name="dest", requirements={ "univId": "\d+" })
     */
    public function univ(int $univId): Response
    {
        $univ = $this->universityService->getUnivById($univId);

        return $this->render('destinationerasmus/dest.html.twig', [
            "univ" => $univ
        ]);
    }

    /**
     * @return Response
     * @Route(path="/user", name="userPage")
     */
    public function user(): Response
    {
        $user = $this->userService->getUserByMail($this->getUser()->getUsername());

        return $this->render('destinationerasmus/user.html.twig', [
            'user'=>$user
        ]);
    }
}
