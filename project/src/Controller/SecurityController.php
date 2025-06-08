<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $errorMessage = null;

        if ($lastUsername) {
            $user = $entityManager->getRepository(Users::class)->findOneBy(['email' => $lastUsername]);
            if ($user && $user->isIsBanned()) {
                $errorMessage = 'Tu cuenta ha sido deshabilitada. Si tienes alguna consulta, por favor contacta con soporte.';
            } elseif ($error) {
                $errorMessage = 'Las credenciales introducidas no son válidas.';
            }
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error || $errorMessage,
            'error_message' => $errorMessage
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // El logout es manejado por Symfony Security
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
