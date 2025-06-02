<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="app_error")
     */
    public function errorPage(Request $request): Response
    {

        $statusCode = $request->attributes->get('error_code', 500);

        return $this->render('error/error.html.twig', [
            'code' => $statusCode,
        ]);
    }
}