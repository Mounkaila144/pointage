<?php

// Change the namespace according to the location of this class in your bundle
namespace App\Evenlister\LoginListener;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginListener
{
    protected $userManager;
    protected $router;
    protected $security;
    protected $dispatcher;

    public function __construct(UserManagerInterface $userManager, Router $router, SecurityContext $security, EventDispatcher $dispatcher)
    {
        $this->userManager = $userManager;
        $this->router = $router;
        $this->security = $security;
        $this->dispatcher = $dispatcher;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->dispatcher->addListener(KernelEvents::RESPONSE, array($this, 'onKernelResponse'));
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // Important: redirect according to user Role
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $event->setResponse(new RedirectResponse($this->router->generate("admin_homepage")));
        } elseif ($this->security->isGranted('ROLE_MANAGER')) {
            $event->setResponse(new RedirectResponse($this->router->generate("manager_homepage")));
        } else {
            $event->setResponse(new RedirectResponse($this->router->generate("default_homepage")));
        }
    }
}