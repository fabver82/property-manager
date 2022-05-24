<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Picture;
use App\Form\PropertyType;
use App\Form\PropertyPictureUploadType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/property')]
class PropertyController extends AbstractController

{
    private $category = 'Property';


//    this function is used to render the menu with the list of existing properties
    public function propertyMenu(PropertyRepository $propertyRepository): Response
    {

        return $this->render('back/includes/_propertyMenu.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('back/property/index.html.twig', [
            'page' => 'List',
            'category' => $this->category,
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PropertyRepository $propertyRepository): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
//        dump($property);
        if ($form->isSubmitted() && $form->isValid()) {

            $propertyRepository->add($property, true);

            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/property/new.html.twig', [
            'page' => 'New',
            'category' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('back/property/show.html.twig', [
            'page' => 'Details',
            'category' => $this->category,
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyRepository->add($property, true);

            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/property/edit.html.twig', [
            'page' => 'Edit',
            'category' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/pictures', name: 'app_property_pictures', methods: ['GET','POST'])]
    public function uploadPicture(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
//        $picture = new Picture();
        $form = $this->createForm(PropertyPictureUploadType::class);
        $form->handleRequest($request);
//
        if ($form->isSubmitted() && $form->isValid()) {
            $pictures=$form->get('pictures')->getData();
            foreach ($pictures as $picture){
                $file = md5(uniqid()).'.'.$picture->guessExtension();
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $file
                );
                $propPic = new Picture();
                $propPic->setFilename($file);
                $propPic->setProperty($property);
                $property->addPicture($propPic);
            }
            dump($property);
            $propertyRepository->add($property, true);
//
//
//            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/property/upload.html.twig', [
            'page' => 'Upload',
            'category' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $propertyRepository->remove($property, true);
        }

        return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
