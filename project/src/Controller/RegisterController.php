<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->getUser()) 
        {
            return $this->redirectToRoute('app_home');
        }

        $user = new Users();
        $form = $this->createForm(UsersForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            try 
            {
                $password = $form->get('password')->getData();
                $passwordConfirmation = $form->get('password_confirmation')->getData();

                if ($password !== $passwordConfirmation) 
                {
                    $this->addFlash('error', 'Las contraseñas no coinciden');
                    return $this->redirectToRoute('app_register');
                }
                
                $user->setCreatedAt(new \DateTimeImmutable());
                
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', '¡Usuario registrado correctamente!');
                
                return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
            } 
            catch (\Exception $e) 
            {
                $this->addFlash('error', 'Error al registrar el usuario');
                return $this->redirectToRoute('app_register', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('pages/register.html.twig', [
            'registrationForm' => $form->createView(),
        ], new Response(
            null,
            $form->isSubmitted() && !$form->isValid() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK
        ));
    }
}