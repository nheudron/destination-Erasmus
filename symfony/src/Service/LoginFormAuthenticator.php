<?php

namespace App\Service;

use App\DTO\LoginDto;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /** @var SecurityService */
    private $securityService;
    /** @var RouterInterface */
    private $router;
    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(RouterInterface $router, FormFactoryInterface $ff, SecurityService $securityService)
    {
        $this->router = $router;
        $this->formFactory = $ff;
        $this->securityService = $securityService;
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl()
    {
        return $this->router->generate("app_login");
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        $dto = new LoginDto($this->formFactory, $request);
        $form = $dto->getForm();
        $form->handleRequest($request);
        if (!$form->isValid() || !$form->isSubmitted()){
            throw new InvalidCsrfTokenException("Invalid form");
        }
        $request->getSession()->set(Security::LAST_USERNAME, $dto->getMail());
        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var LoginDto $credentials */
        $user = $this->securityService->findUserByMail($credentials->getMail());
        if (!$user)
        {
            throw new CustomUserMessageAuthenticationException("Username does not exist");
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var LoginDto $credentials */
        return $this->securityService->isPasswordValid($user, $credentials->getUserPass());
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        if ($targetPath) return new RedirectResponse($targetPath);
        return new RedirectResponse($this->router->generate("home"));
    }
}