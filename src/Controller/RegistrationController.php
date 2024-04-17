<?php

namespace App\Controller;

use App\Entity\AccessToken;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\Security\SecurityService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        SecurityService $securityService,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $accessToken = $this->createToken($securityService, $user);
            $user->setAccessToken($accessToken);

            $entityManager->persist($user);
            $entityManager->flush();


            // do anything else you need here, like send an email

            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    /**
     * @param SecurityService $securityService
     * @param User $user
     * @return AccessToken
     */
    private function createToken(SecurityService $securityService, User $user): AccessToken
    {
        $accessToken = new AccessToken();
        $accessToken->setToken($securityService->generateToken());
        $accessToken->setExpirationTime(Carbon::now()->addDays(60));
        $accessToken->setAuthUser($user);

        return $accessToken;
    }
}
