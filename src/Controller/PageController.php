<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\Picture;
use App\Form\PageType;
use App\Form\PictureUploadType;
use App\Form\PageSectionType;
use App\Repository\PageRepository;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    #[Route('/{id}/picture/edit', name: 'page_section_edit', methods: ['GET', 'POST'])]
    public function createSection(Request $request, Picture $picture, PictureRepository $pictureRepository, PageRepository $pageRepository): Response
    {
        $form = $this->createForm(PageSectionType::class, $picture);
        $page = $picture->getPage();
        if (!is_null($page->getBanner()) && $page->getBanner()->getId()==$picture->getId()){
            $form->get('banner')->setData(true);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('banner')->getData()){
                $page->setBanner($picture);
            } else {
                $page->addSection($picture);
                dump($page);
            }
            $pictureRepository->add($picture, true);

            return $this->redirectToRoute('app_page_show', ['id'=>$picture->getPage()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/page/edit.html.twig', [
            'pageBC' => 'Edit',
            'categoryBC' => $this->category,
            'page' => $page,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/pictures', name: 'app_page_pictures', methods: ['GET','POST'])]
    public function uploadPicture(Request $request, Page $page, PageRepository $pageRepository): Response
    {
        $form = $this->createForm(PictureUploadType::class);
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
        return $this->renderForm('back/page/upload.html.twig', [
            'pageBC' => 'Upload',
            'categoryBC' => $this->category,
            'page' => $page,
            'form' => $form,
        ]);
    }
//    TODO: refactor picture deletion into a specific controller ?
    #[Route('/delete/picture/{id}', name: 'app_page_picture_delete', methods: ['DELETE'])]
    public function deletePicture(Picture $picture, PictureRepository $pictureRepo, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        if($this->isCsrfTokenValid('delete'.$picture->getId(),$data['_token'])){
            $page = $picture->getPage();
            unlink($this->getParameter('pictures_directory').'/'.$picture->getFilename());
            $page->removePicture($picture);
            if($page->getBanner()->getId()==$picture->getId()){
                $page->setBanner(null);
            }
            $pictureRepo->remove($picture,true);

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Invalid Token'],400);
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
