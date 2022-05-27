<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Picture;
use App\Form\PageType;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class PageController extends AbstractController
{
    private $category = 'Page';

    //    this function is used to render the menu with the list of existing properties
    public function pageMenu(PageRepository $pageRepository): Response
    {

        return $this->render('back/includes/_pageMenu.html.twig', [
            'pages' => $pageRepository->findAll(),
            'pageBC' => 'Index',
            'categoryBC' => $this->category,
        ]);
    }
    #[Route('/', name: 'app_page_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('back/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
            'pageBC' => 'Index',
            'categoryBC' => $this->category,
        ]);
    }

    #[Route('/new', name: 'app_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PageRepository $pageRepository): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRepository->add($page, true);

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/page/new.html.twig', [
            'page' => $page,
            'pageBC' => 'New',
            'form' => $form,
            'categoryBC' => $this->category,
        ]);
    }

    #[Route('/{id}', name: 'app_page_show', methods: ['GET'])]
    public function show(Page $page): Response
    {
        return $this->render('back/page/show.html.twig', [
            'page' => $page,
            'pageBC' => 'Show',
            'categoryBC' => $this->category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageRepository->add($page, true);

            return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
            'categoryBC' => $this->category,
            'pageBC' => 'Edit',
        ]);
    }
    #[Route('/{id}/pictures', name: 'app_page_pictures', methods: ['GET','POST'])]
    public function uploadPicture(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        $form = $this->createForm(PropertyPictureUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();
            foreach ($pictures as $picture) {
                $file = md5(uniqid()) . '.' . $picture->guessExtension();
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $file
                );
                $propPic = new Picture();
                $propPic->setType('Page');
                $propPic->setFilename($file);
                $propPic->setPage($page);
                $page->addPicture($propPic);
            }
            $pageRepository->add($page, true);
//            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }
    }
    #[Route('/{id}', name: 'app_page_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $pageRepository->remove($page, true);
        }

        return $this->redirectToRoute('app_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
