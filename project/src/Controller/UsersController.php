<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersForm;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('/panel/users')]
final class UsersController extends AbstractController
{
    #[Route(name: 'app_users_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('panel/users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('panel/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) 
        {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/toggle-ban', name: 'app_users_toggle_ban', methods: ['POST'])]
    public function toggleBan(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('toggle_ban'.$user->getId(), $request->request->get('_token'))) {
            $user->setIsBanned(!$user->isIsBanned());
            $entityManager->flush();
            
            $status = $user->isIsBanned() ? 'inhabilitada' : 'habilitada';
            $this->addFlash('success', "La cuenta ha sido {$status} correctamente.");
        }

        return $this->redirectToRoute('app_users_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
    }
}