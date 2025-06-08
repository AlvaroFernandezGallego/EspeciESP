<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        $statusCode = $exception instanceof HttpException ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
        
        $response = new Response(
            $this->renderView('error/error.html.twig', [
                'code' => $statusCode,
                'message' => $this->getErrorMessage($statusCode)
            ]),
            $statusCode
        );

        // Asegurar que no se cachee ninguna página de error
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    #[Route('/error/403', name: 'error_403')]
    public function error403(): Response
    {
        return $this->render('error/error.html.twig', [
            'message' => 'No tienes permisos para acceder a esta sección.',
            'code' => 403
        ], new Response('', 403));
    }

    private function getErrorMessage(int $statusCode): string
    {
        return match ($statusCode) {
            400 => 'La solicitud contiene errores de sintaxis y no puede ser procesada.',
            401 => 'Necesitas iniciar sesión para acceder a esta página.',
            403 => 'No tienes permisos para acceder a esta página.',
            404 => 'La página que buscas no existe.',
            405 => 'El método de solicitud no está permitido para esta URL.',
            408 => 'El servidor agotó el tiempo de espera de la solicitud.',
            429 => 'Demasiadas solicitudes en poco tiempo.',
            500 => 'Ha ocurrido un error interno en el servidor.',
            502 => 'El servidor recibió una respuesta no válida.',
            503 => 'El servicio no está disponible temporalmente.',
            504 => 'El servidor no recibió una respuesta a tiempo.',
            default => 'Ha ocurrido un error inesperado.'
        };
    }
}