<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Entity\Universities;
use App\Model\UnivListModel;
use App\Model\FiliereListModel;
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
    private $filiereService;

    public function __construct
    (
        IUserService $userService,
        IUniversityService $universityService,
        IFiliereService $filiereService
    )
    {
        $this->userService = $userService;
        $this->universityService = $universityService;
        $this->filiereService = $filiereService;
    }
    /**
     * @return Response
     * @Route(path="/", name="home")
     */
    public function home(Request $request, PaginatorInterface $paginator)
    {
        /** @var Universities[] $gameList */
        $gameList = $this->universityService->getAllUniv();
        $model = new UnivListModel();
        $model->setUnivList($gameList);

        $model = $paginator->paginate(
            $gameList, // Requête contenant les données à paginer (ici nos universités)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        /** @var Filiere[] $gameListFilieres */
        $gameListFilieres = $this->filiereService->getAllFilieres();
        $modelFiliere = new FiliereListModel();
        $modelFiliere->setFiliereList($gameListFilieres);

        return $this->render('destinationerasmus/home.html.twig', [
            'model' => $model,
            'modelFiliere' => $modelFiliere
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