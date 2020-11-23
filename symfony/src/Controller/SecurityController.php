<?php
namespace App\Controller;

use App\DTO\LoginDto;
use App\DTO\RegistrationDto;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /** @var SecurityService */
    private $security;
    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(SecurityService $securityService, FormFactoryInterface $formFactory)
    {
        $this->security = $securityService;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_register", path="/register")
     */
    public function registerAction(Request $request) : Response
    {
        $dto = new RegistrationDto($this->formFactory, $request);
        $form = $dto->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->security->registerUser($dto->getEmail(), $dto->getClearPassword(), $dto->getFirstName(), $dto->getLastName());
            $this->addFlash('notice', "{$dto->getFirstName()} {$dto->getLastName()} successfully registered");
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig', ['form'=>$form->createView()]);
    }
    /**
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils) : Response
    {
        $dto = new LoginDto($this->formFactory, $request);
        $dto->setMail($authenticationUtils->getLastUsername());
        return $this->render('security/login.html.twig', [
            "form" => $dto->getForm()->createView(),
            "myUser" => $this->getUser(),
            "authError" => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_logout", path="/logout")
     */
    public function logoutAction(Request $request) : Response
    {
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="protected_content", path="/protected")
     */
    public function protectedAction(Request $request) : Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        return new Response("TODO");
    }
}