<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Picture;
use App\Entity\Price;
use App\Form\PropertySectionType;
use App\Form\PropertyType;
use App\Form\PriceType;
use App\Form\PictureUploadType;
use App\Repository\BookingRepository;
use App\Repository\PriceRepository;
use App\Repository\PropertyRepository;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'pageBC' => 'List',
            'categoryBC' => $this->category,
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
            'pageBC' => 'New',
            'categoryBC' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('back/property/show.html.twig', [
            'pageBC' => 'Details',
            'categoryBC' => $this->category,
            'property' => $property,
        ]);
    }
    #[Route('/{id}/bookings', name: 'app_property_bookings', methods: ['GET'])]
    public function bookingList(Property $property): Response
    {
        return $this->render('back/booking/index.html.twig', [
            'bookings' => $property->getBookings(),
            'pageBC' => 'Bookings',
            'categoryBC' => $this->category,
            'property' => $property,
        ]);
    }
    #[Route('/{id}/prices', name: 'app_property_prices', methods: ['GET'])]
    public function priceList(Property $property): Response
    {
        return $this->render('back/price/index.html.twig', [
            'prices' => $property->getPrices(),
            'pageBC' => 'Prices',
            'categoryBC' => $this->category,
            'property' => $property,
        ]);
    }
    private function checkPriceExist($price,$property): Bool
    {
        foreach($property->getPrices() as $property_price){
            if (($price->getStartDate()>=$property_price->getStartDate()
                && $price->getStartDate()<=$property_price->getEndDate())
            || (
                $price->getEndDate()>=$property_price->getStartDate()
                && $price->getEndDate()<=$property_price->getEndDate()
                ))
            {
                return true;
            }
        }
        return false;
    }
    #[Route('/{id}/prices/new', name: 'app_property_prices_new', methods: ['GET', 'POST'])]
    public function priceNew(Request $request, Property $property, PriceRepository $priceRepository): Response
    {
        $price = new Price();
//        dump($property);
        $price->setProperty($property);
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($this->checkPriceExist($price,$property));
            if (!$this->checkPriceExist($price,$property)){
                $priceRepository->add($price, true);
                return $this->redirectToRoute('app_property_prices', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->renderForm('back/price/new.html.twig', [
            'property' => $property,
            'price' => $price,
            'form' => $form,
            'pageBC' => 'New Price',
            'categoryBC' => $this->category,
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
            'pageBC' => 'Edit price',
            'categoryBC' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/picture/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    public function createSection(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        $form = $this->createForm(PropertySectionType::class, $picture);
        $property = $picture->getProperty();
        if (!is_null($property->getMainPicture()) && $property->getMainPicture()->getId()==$picture->getId()){
            $form->get('main_picture_id')->setData(true);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('main_picture_id')->getData()){
                $property->setMainPicture($picture);
            }
            if ($picture->getId()==$property->getMainPicture()->getId() and !$form->get('main_picture_id')->getData()){
                $property->setMainPicture(null);
            }
            $pictureRepository->add($picture, true);

            return $this->redirectToRoute('app_property_pictures', ['id'=>$picture->getProperty()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/property/edit.html.twig', [
            'pageBC' => 'Edit',
            'categoryBC' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/pictures', name: 'app_property_pictures', methods: ['GET','POST'])]
    public function uploadPicture(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        $form = $this->createForm(PictureUploadType::class);
        $form->handleRequest($request);

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
//            dump($property);
            $propertyRepository->add($property, true);
//
//
//            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/property/upload.html.twig', [
            'pageBC' => 'Upload',
            'categoryBC' => $this->category,
            'property' => $property,
            'form' => $form,
        ]);
    }
    #[Route('/delete/picture/{id}', name: 'app_picture_delete', methods: ['DELETE'])]
    public function deletePicture(Picture $picture, PictureRepository $pictureRepo, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        if($this->isCsrfTokenValid('delete'.$picture->getId(),$data['_token'])){
            unlink($this->getParameter('pictures_directory').'/'.$picture->getFilename());
            $property = $picture->getProperty();
            if ($picture->getId()==$property->getMainPicture()->getId()){
                $property->setMainPicture(null);
            }
            $property->removePicture($picture);
            $pictureRepo->remove($picture,true);
           return new JsonResponse(['success' => 1]);
        }else{
           return new JsonResponse(['error' => 'Invalid Token'],400);
        }
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
