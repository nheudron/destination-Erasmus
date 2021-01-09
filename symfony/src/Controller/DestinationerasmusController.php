<?php

namespace App\Controller;

use App\Entity\Majors;
use App\Entity\Search;
use App\Entity\Filiere;
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

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class DestinationerasmusController extends AbstractController
{
    /** @var IUserService */
    private $userService;
    /** @var IUniversityService */
    private $universityService;
    /** @var IFiliereService */
    private $branchService;
    /** @var Serializer */
    private $serializer;

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
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $this->serializer = new Serializer([$normalizers], $encoders);
    }

    private function isCurrentUserAdmin(): bool
    {
        $isUserAdmin = false;
        if (null !== $this->getUser()) {
            $user = $this->userService->getUserByMail($this->getUser()->getUsername());
            $role = $user->getRoles();
            if (in_array("ROLE_ADMIN", $role)) {
                $isUserAdmin = true;
            }
        }
        return $isUserAdmin;
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route(path="/", name="home")
     */
    public function home(Request $request, PaginatorInterface $paginator): Response
    {
        $isAdmin = $this->isCurrentUserAdmin();
        

        /*$search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form = handleRequest($request);*/


        /** @var Majors[] $majorList */
        $majorList = $this->branchService->getAllBranches();

        $univPage = $paginator->paginate (
            $this->universityService->getAllUnivByQuery(),  // Requête contenant les données à paginer (ici nos universités)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5   // Nombre de résultats par page
        );
        
        return $this->render('destinationerasmus/home.html.twig', [
            'branchList' => $majorList,
            'univPage' => $univPage,
            'isAdmin' => $isAdmin
            /*'form' => $form->createView(),*/
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
        $usersFav = $univ->getFavUsersList();
        $subjectsList = $univ->getSubjects();
        return $this->render('destinationerasmus/dest.html.twig', [
            "univ" => $univ,
            "usersFav" => $usersFav,
            "subjectsList" => $subjectsList
        ]);
    }

        /**
     * @return Response
     * @Route(path="/lastTrip", name="lastTrip")
     */
    public function lastTrip(Request $request, PaginatorInterface $paginator): Response
    {
        $univPage = $paginator->paginate (
            $this->universityService->getAllUnivByQuery(),  // Requête contenant les données à paginer (ici nos universités)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5   // Nombre de résultats par page
        );

        if (null !== $this->getUser()) {
            $user = $this->userService->getUserByMail($this->getUser()->getUsername());
            $favorites = $user->getFavorites();

            return $this->render('destinationerasmus/lastTrip.html.twig', [
                'univPage' => $univPage
            ]);
        }else {
            $returnvar = $this->redirectToRoute("app_login");
        }
        return $returnvar;
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
        if (null !== $this->getUser()) {
            $user = $this->userService->getUserByMail($this->getUser()->getUsername());
            $favorites = $user->getFavorites();

            $returnvar = $this->render('destinationerasmus/fav.html.twig', [
                'favorites'=>$favorites
            ]);
        }else {
            $returnvar = $this->redirectToRoute("app_login");
        }
        return $returnvar;
    }

    /**
     * @param int $univId
     * @return JSONResponse
     * @Route(path="/togglefav/{univId}", name="togglefav", requirements={ "univId": "\d+" })
     */
    public function togglefav(int $univId): Response
    {
        $returnvar = new JsonResponse();
        if (null !== $this->getUser()) {
            $user = $this->userService->getUserByMail($this->getUser()->getUsername());
            $univ = $this->universityService->getUnivById($univId);
            $present = $user->toggleFav($univ);
            $likes = $univ->getFavNb();
            $idUniv = $univ->getId();
            $returnvar->setData(['redirect' => false,'present?' => $present,'likes' => $likes,'idUniv' => $idUniv]);
        }else {
            $returnvar->setData(['redirect' => true]);
        }
        $this->getDoctrine()->getManager()->flush();
        return $returnvar;
    }

    /**
     * @return JSONResponse
     * @Route(path="/getallfav", name="getallfav")
     */
    public function getallfav(): Response
    {
        $returnvar = new JsonResponse();
        if (null !== $this->getUser()) {
            $user = $this->userService->getUserByMail($this->getUser()->getUsername());
            $univs = $user->getFavorites();
            $univsJSON = array();
            for ($i=0; $i < count($univs); $i++) { 
                $tempvar = array($i => "univ".$univs[$i]->getId());
                $univsJSON += $tempvar;
            }
            $returnvar->setData(['connected' => true,'univs' => $univsJSON]);
        }else {
            $returnvar->setData(['connected' => false]);
        }
        $this->getDoctrine()->getManager()->flush();
        return $returnvar;
    }

    /**
     * @return Response
     * @Route(path="/admin", name="adminPage")
     */
    public function admin(): Response
    {
        if($this->isCurrentUserAdmin()){
            $univs = $this->universityService->getAllUniv();
            $branchList = $this->branchService->getAllBranches();

            $returnvar = $this->render('destinationerasmus/admin.html.twig', [
                'univs'=>$univs,
                'branchList'=>$branchList
            ]);
        }else{
            $returnvar = new Response(null,403);
        }
        return $returnvar;
    }

    /**
     * @param Request $request
     * @return JSONResponse
     * @Route(path="/updateUniv", name="updateUnivPage")
     */
    public function updateUniv(Request $request): Response
    {
        $returnvar = new JsonResponse();
        if ($this->isCurrentUserAdmin()) {
            $params = $request->query->all();
            for($i=0; $i < count($params["courseName"]); $i++){
                if (!isset($params["courseActive"][$i])) {
                    $params["courseActive"][$i] = "off";
                }
            }
            if(!isset($params["dormitories"])){
                $params["dormitories"] = "off";
            }
            $returnvar->setData(['admin' => true,'content' => $params]);
        }else{
            $returnvar->setData(['admin' => false]);
        }
        return $returnvar;
    }

    /**
     * @param int $univId
     * @return JSONResponse
     * @Route(path="/univModifDetails/{univId}", name="univModifDetailsPage",requirements={ "univId": "\d+" })
     */
    public function univModifDetails(int $univId): Response
    {
        $returnvar = new JsonResponse();
        $univ = $this->universityService->getUnivById($univId);
        $univjson = $this->serializer->serialize($univ,'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => 
                ["favUsersList","cityUniversities","countryCities","univQuestions","univComments","accommodations","flag","favNb","universities","__initializer__","__cloner__","__isInitialized__"]
            ]);
        $returnvar->setData(json_decode($univjson));
        return $returnvar;
    }
}