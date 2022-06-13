<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Property;
use App\Entity\Settings;
use App\Form\AvailabilityType;
use App\Repository\PageRepository;
use App\Repository\PropertyRepository;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(SettingsRepository $settingsRepository, PageRepository $pageRepository, PropertyRepository $propertyRepository, Request $request): Response
    {
        //TODO : get only the title of all pages, we dont need all datas
        $pages = $pageRepository->findAll();
        $properties = $propertyRepository->findAll();
        $settings = $settingsRepository->find(1);
        $form=$this->createForm(AvailabilityType::class);
        $searchDates=[];
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchDates['start']= $form->get('start_date')->getData();
            $searchDates['end'] = $form->get('end_date')->getData();
            foreach ($properties as $property){
                $property->setPriceList($searchDates['start'],$searchDates['end']);
            }
        }
        dump($properties);

        return $this->renderForm('front/base.html.twig', [
            'controller_name' => 'FrontController',
            'settings'=>$settings,
            'pages'=>$pages,
            'properties' => $properties,
            'availability_form' => $form,
            'searchDates' => $searchDates,
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
        return $this->render('front/property/details.html.twig', [
            'controller_name' => 'FrontController',
            'settings' => $settings,
            'property' => $property,
            'pages' => $pages,
            'properties' => $properties,
        ]);
    }
}
