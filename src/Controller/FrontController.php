<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Settings;
use App\Repository\PageRepository;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(SettingsRepository $settingsRepository, PageRepository $pageRepository): Response
    {
        $pages = $pageRepository->findAll();
        $settings = $settingsRepository->find(1);
        return $this->render('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings'=>$settings,
            'pages'=>$pages,
        ]);
    }
    #[Route('/{title}', name: 'app_page')]
    public function page(SettingsRepository $settingsRepository, PageRepository $pageRepository,Page $page): Response
    {
//        $pages = $pageRepository->findOneBy('landing_title'=> $page);
        $settings = $settingsRepository->find(1);
//        TODO:link to right template, and create the template
        return $this->render('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings'=>$settings,
            'page'=>$page,
        ]);
    }
}
