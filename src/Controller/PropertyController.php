<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
//    #[Route('/property', name: 'app_property')]
//    public function index(): Response
//    {
//        return $this->render('property/index.html.twig', [
//            'controller_name' => 'PropertyController',
//        ]);
//    }
    #[Route('/admin/property/new', name: 'app_new_property')]
    public function newProperty(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $property = $form->getData();
            dump($property);
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }
        return $this->renderForm('back/property/new_property.html.twig', [
            'category' => 'Property',
            'page' => 'Create New Property',
            'form' => $form,
        ]);
    }
}
