<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\User;

class ProfileController extends AbstractController
{
    #[Route('admin/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        dump($user);

        return $this->render('back/user/profile.html.twig', [
            'pageBC' => 'Profile',
            'categoryBC' => 'Users',
            'user' => $user,
        ]);
    }
    #[Route('admin/profile/edit/{username}', name: 'app_edit_profile', methods: ['GET', 'POST'])]
    public function edit(Request $request,User $user,UserRepository $userRepo ): Response
    {
//        $user = $this->getUser();
        dump($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo->add($user, true);

            return $this->redirectToRoute('app_profile', ['username'=>$user->getUsername()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('back/user/edit.html.twig', [
            'pageBC' => 'Profile',
            'categoryBC' => 'Users',
            'user' => $user,
            'form' =>$form->createView(),
        ]);
    }
}
