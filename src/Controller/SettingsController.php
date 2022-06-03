<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/settings')]
class SettingsController extends AbstractController
{
    private $category = 'Settings';
    #[Route('/', name: 'app_settings', methods: ['POST'])]
    public function index(Request $request, Settings $settings, SettingsRepository $settingsRepository): Response
    {
        $settings = $settingsRepository->find(1);
        $form = $this->createForm(SettingsType::class, $settings);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $settingsRepository->add($settings, true);

            return $this->redirectToRoute('app_settings', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('settings/index.html.twig', [
            'settings' => $settings,
            'form' => $form,
            'pageBC' => 'edit',
            'categoryBC' => $this->category,
        ]);
    }

}
