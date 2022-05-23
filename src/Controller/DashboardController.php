<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('back/dashboard.html.twig', [
            'category' => 'Admin',
            'page' => 'Dashboard',
        ]);
    }
}
