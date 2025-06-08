<?php

namespace App\Controller;

use App\Form\ProfileEditForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('pages/profile.html.twig');
    }

    #[Route('/profile/delete', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(
        Request $request, 
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();
        $submittedPassword = $request->request->get('password');

        if (!$passwordHasher->isPasswordValid($user, $submittedPassword)) {
            $this->addFlash('error', 'Contraseña incorrecta');
            return $this->redirectToRoute('app_profile');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->container->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        $this->addFlash('success', 'Tu cuenta ha sido eliminada');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(
        Request $request, 
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(ProfileEditForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Verificar si se está intentando cambiar la contraseña
                $newPassword = $form->get('new_password')->getData();
                if ($newPassword) {
                    $newPasswordConfirm = $form->get('new_password_confirm')->getData();
                    
                    if ($newPassword !== $newPasswordConfirm) {
                        $this->addFlash('error', 'Las contraseñas no coinciden');
                        return $this->redirectToRoute('app_profile_edit');
                    }
                    
                    // Hash y guarda la nueva contraseña
                    $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                    $user->setPassword($hashedPassword);
                }

                // Guarda los cambios en la base de datos
                $entityManager->flush();
                
                $this->addFlash('success', 'Perfil actualizado correctamente');
                return $this->redirectToRoute('app_profile');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al actualizar el perfil');
            }
        }

        return $this->render('pages/profile_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
