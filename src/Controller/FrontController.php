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
    #[Route('/page/{title}', name: 'front_pages_show')]
    public function page(SettingsRepository $settingsRepository, PageRepository $pageRepository, PropertyRepository $propertyRepository,Page $page,int $id=1): Response
    {
        $pages = $pageRepository->findAll();
        $properties = $propertyRepository->findAll();
        $settings = $settingsRepository->find($id);
//        TODO:link to right template, and create the template
        return $this->render('front/pages/page.html.twig', [
            'controller_name' => 'FrontController',
            'settings' => $settings,
            'page' => $page,
            'pages' => $pages,
            'properties' => $properties,
        ]);
    }
    #[Route('/property/{id}', name: 'front_property_show')]
    public function property(SettingsRepository $settingsRepository, PageRepository $pageRepository,PropertyRepository $propertyRepository,Property $property): Response
    {
        $settings = $settingsRepository->find(1);
        $pages = $pageRepository->findAll();
        $properties = $propertyRepository->findAll();
//        TODO:link to right template, and create the template
        return $this->render('front/property/details.html.twig', [
            'controller_name' => 'FrontController',
            'settings' => $settings,
            'property' => $property,
            'pages' => $pages,
            'properties' => $properties,
        ]);
    }
}
