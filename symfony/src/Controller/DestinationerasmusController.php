<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Entity\Universities;
use App\Model\UnivListModel;
use App\Service\IFiliereService;
use App\Service\IUserService;
use App\Service\IUniversityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; 

class DestinationerasmusController extends AbstractController
{
    /** @var IUserService */
    private $userService;
    /** @var IUniversityService */
    private $universityService;
    /** @var IFiliereService */
    private $branchService;

    public function __construct
    (
        IUserService $userService,
        IUniversityService $universityService,
        IFiliereService $branchService
    )
    {
        $this->userService = $userService;
        $this->universityService = $universityService;
        $this->branchService = $branchService;
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route(path="/", name="home")
     */
    public function home(Request $request, PaginatorInterface $paginator)
    {
        /** @var Filiere[] $branchList */
        $branchList = $this->branchService->getAllFilieres();

        /** @var Universities[] $univList */
        $univList = $this->universityService->getAllUniv();
        $univModel = new UnivListModel();
        $univModel->setUnivList($univList);

        $univPage = $paginator->paginate(
            $univModel,  // Requête contenant les données à paginer (ici nos universités)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5   // Nombre de résultats par page
        );

        return $this->render('destinationerasmus/home.html.twig', [
            'branchList' => $branchList,
            'univPage' => $univPage
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

    /**
     * @return Response
     * @Route(path="/fav", name="fav")
     */
    public function fav(): Response
    {
        return $this->render('destinationerasmus/fav.html.twig');
    }
}