<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Property;
use App\Entity\Settings;
use App\Repository\PageRepository;
use App\Repository\PropertyRepository;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(SettingsRepository $settingsRepository, PageRepository $pageRepository, PropertyRepository $propertyRepository): Response
    {
        //TODO : get only the title of all pages, we dont need all datas
        $pages = $pageRepository->findAll();
        $properties = $propertyRepository->findAll();
        $settings = $settingsRepository->find(1);
        return $this->render('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings'=>$settings,
            'pages'=>$pages,
            'properties' => $properties,
        ]);
    }
    #[Route('/{title}', name: 'page_show')]
    public function page(SettingsRepository $settingsRepository, PageRepository $pageRepository,Page $page,int $id=1): Response
    {
        $settings = $settingsRepository->find($id);
//        TODO:link to right template, and create the template
        return $this->render('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings' => $settings,
            'page' => $page,
        ]);
    }
    #[Route('/property/{id}', name: 'app_property')]
    public function property(SettingsRepository $settingsRepository, PageRepository $pageRepository,Property $property): Response
    {
        $settings = $settingsRepository->find(1);
//        TODO:link to right template, and create the template
        return $this->render('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings' => $settings,
            'property' => $property,
        ]);
    }
}
