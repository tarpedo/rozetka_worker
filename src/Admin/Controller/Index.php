<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class Index extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('', name: 'admin_index')]
    public function index(\Twig\Environment $twig): Response
    {
        return new Response(
            $twig->render(
                'admin/index.html.twig',
            )
        );
    }

}