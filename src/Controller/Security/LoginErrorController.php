<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginErrorController extends AbstractController
{
    #[Route('/login/error', name: 'login_error')]
    public function index(): Response
    {
        return $this->render('login_error/index.html.twig', [
            'controller_name' => 'LoginErrorController',
        ]);
    }
}
