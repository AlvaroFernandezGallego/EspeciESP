<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class OpinionController extends AbstractController
{
    #[Route('/opinion', name: 'app_opinion')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $message = new Messages();
            $message->setUser($this->getUser());
            $message->setCreatedAt(new \DateTimeImmutable());
            $message->setIsRead(false);
            
            $form = $this->createForm(MessagesForm::class, $message);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($message);
                $entityManager->flush();

                $this->addFlash('success', 'Tu mensaje ha sido enviado correctamente');
                return $this->redirectToRoute('app_home');
            }

            return $this->render('pages/opinion_form.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Ha ocurrido un error al enviar el mensaje');
            return $this->redirectToRoute('app_home');
        }
    }
}
