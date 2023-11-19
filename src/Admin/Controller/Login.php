<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Login extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/admin/login', name: 'admin_login')]
    public function indexAction(\Twig\Environment $twig): Response
    {
        return new Response(
            $twig->render(
                'admin/login.html.twig',
                [
                    'base' => [
                        'title' => 'Login',
                    ],
                ]
            )
        );
    }
}