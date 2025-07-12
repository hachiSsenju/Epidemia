<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    // #[Route('/login', name: 'app_login')]
    //  public function login(AuthenticationUtils $authenticationUtils): Response
    //   {
    //      $error = $authenticationUtils->getLastAuthenticationError();
    //      $lastUsername = $authenticationUtils->getLastUsername();
    //       return $this->render('security/login.html.twig', [
    //          'controller_name' => 'LoginController',
    //          'last_username' => $lastUsername,
    //          'error'         => $error,
    //       ]);
    //   }
}
