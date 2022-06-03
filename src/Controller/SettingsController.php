<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Form\SettingsType;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request, Settings $settings, SettingsRepository $settingsRepository,int $id=1): Response
    {
        $settings = $settingsRepository->find($id);
//        $settings = new Settings();
        dump($settings);
        $form = $this->createForm(SettingsType::class, $settings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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

}
