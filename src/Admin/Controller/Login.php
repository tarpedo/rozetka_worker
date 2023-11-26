<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/login')]
class Login extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('', name: 'admin_login_index')]
    public function index(\Twig\Environment $twig): Response
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