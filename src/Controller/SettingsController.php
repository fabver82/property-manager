<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Entity\Picture;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/admin/settings')]
class SettingsController extends AbstractController
{
    private $category = 'Settings';
//    TODO: doesnt work without parameter
    #[Route('/{!id}', name: 'app_settings', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function index(Request $request, SettingsRepository $settingsRepository,int $id=1): Response
    {
        $settings = $settingsRepository->find($id);
        dump($settings);
        $form = $this->createForm(SettingsType::class, $settings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();
            dump($logo);
            if (!is_null($logo)){
                $file = 'logo.' . $logo->guessExtension();
                $logo->move(
                    $this->getParameter('pictures_directory'),
                    $file
                );
                $settings->setLogo($file);
            }
            $settingsRepository->add($settings, true);

            return $this->redirectToRoute('app_settings', ['id'=>$settings->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('back/settings/edit.html.twig', [
            'settings' => $settings,
            'form' => $form->createView(),
            'pageBC' => 'edit',
            'categoryBC' => $this->category,
        ]);
    }
    #[Route('/slider/{!id}', name: 'app_slider', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function slider(SettingsRepository $settingsRepository,PictureRepository $pictureRepository, int $id=1): Response
    {
        $settings = $settingsRepository->find($id);
        $pictures = $pictureRepository->findBy(['landing_slider'=>null]);
        $slider_pictures = $pictureRepository->findBy(['landing_slider' => 1]);
        dump($pictures);
        return $this->render('back/settings/slider.html.twig', [
            'settings' => $settings,
            'pictures' => $pictures,
            'slider_pictures' => $slider_pictures,
            'pageBC' => 'slider',
            'categoryBC' => $this->category,
        ]);
    }
    #[Route('/slider/add/{id}', name: 'app_slider_add', methods: ['GET','POST'])]
    public function slider_add(Picture $picture,SettingsRepository $settingsRepository,Request $request): Response
    {
        $settings = $settingsRepository->find(1);
        $settings->addLandingSliderPicture($picture);
        $settingsRepository->add($settings,true);
        return $this->redirectToRoute('app_slider', ['id'=>$settings->getId()], Response::HTTP_SEE_OTHER);
    }
}
