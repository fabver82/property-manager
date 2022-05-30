<?php

namespace App\Controller;

use App\Entity\Price;
use App\Entity\Property;
use App\Form\PriceType;
use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/price')]
class PriceController extends AbstractController
{
    private $category = 'Price';

    #[Route('/', name: 'app_price_index', methods: ['GET'])]
    public function index(PriceRepository $priceRepository): Response
    {
        return $this->render('back/price/index.html.twig', [
            'prices' => $priceRepository->findAll(),
            'pageBC' => 'List',
            'categoryBC' => $this->category,
        ]);
    }

//    #[Route('/new', name: 'app_price_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, Property $property, PriceRepository $priceRepository): Response
//    {
//        $price = new Price();
//        dump($property);
////        $price->setProperty();
//        $form = $this->createForm(PriceType::class, $price);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $priceRepository->add($price, true);
//
//            return $this->redirectToRoute('app_price_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('back/price/new.html.twig', [
//            'price' => $price,
//            'form' => $form,
//            'pageBC' => 'New',
//            'categoryBC' => $this->category,
//        ]);
//    }

    #[Route('/{id}', name: 'app_price_show', methods: ['GET'])]
    public function show(Price $price): Response
    {
        return $this->render('back/price/show.html.twig', [
            'price' => $price,
            'pageBC' => 'Show',
            'categoryBC' => $this->category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_price_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Price $price, PriceRepository $priceRepository): Response
    {
        $property = $price->getProperty();
        dump($property);
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $priceRepository->add($price, true);

            return $this->redirectToRoute('app_property_prices', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/price/edit.html.twig', [
            'property' => $property,
            'price' => $price,
            'form' => $form,
            'pageBC' => 'Edit',
            'categoryBC' => $this->category,
        ]);
    }

    #[Route('/{id}', name: 'app_price_delete', methods: ['POST'])]
    public function delete(Request $request, Price $price, PriceRepository $priceRepository): Response
    {
        $property = $price->getProperty();
        if ($this->isCsrfTokenValid('delete'.$price->getId(), $request->request->get('_token'))) {
            $priceRepository->remove($price, true);
        }

        return $this->redirectToRoute('app_property_prices', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
    }
}
