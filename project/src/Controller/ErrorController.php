<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controlador encargado de mostrar una página de error personalizada.
 * 
 * Esta ruta se activa cuando ocurre un error en la aplicación. Recoge el código de error
 * y renderiza una vista Twig para mostrar un mensaje amigable al usuario.
 */
class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="app_error")
     */
    public function errorPage(Request $request): Response
    {

        $statusCode = $request->attributes->get('error_code');

        return $this->render('error/error.html.twig', [
            'code' => $statusCode,
        ]);
    }
}