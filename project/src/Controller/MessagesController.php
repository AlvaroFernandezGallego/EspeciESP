<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/panel/messages')]
class MessagesController extends AbstractController
{
    #[Route('/', name: 'app_messages_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $messages = $entityManager
            ->createQueryBuilder()
            ->select('m')
            ->from(Messages::class, 'm')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('panel/messages/index.html.twig', [
            'messages' => $messages
        ]);
    }

    #[Route('/{id}', name: 'app_messages_show', methods: ['GET'])]
    public function show(Messages $message, EntityManagerInterface $entityManager): Response
    {
        if (!$message->isIsRead()) {
            $message->setIsRead(true);
            $entityManager->flush();
        }

        return $this->render('panel/messages/show.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/{id}', name: 'app_messages_delete', methods: ['POST'])]
    public function delete(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
            $this->addFlash('success', 'Mensaje eliminado correctamente.');
        }

        return $this->redirectToRoute('app_messages_index');
    }
}
