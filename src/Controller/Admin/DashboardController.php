<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Entity\Settings;
use App\Entity\Page;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/easyadmin', name: 'admin')]
    public function index(): Response
    {
//        return parent::index();
        return $this->render('admin/index.html.twig');
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Property Manager');
    }

    public function configureMenuItems(): iterable
    {
//        TODO: check for better icons
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Settings','fa fa-gear',Settings::class);
        yield MenuItem::linkToCrud('Property','fa fa-building',Property::class);
        yield MenuItem::linkToCrud('Page','fa fa-building',Page::class);
        yield MenuItem::linkToCrud('User','fa fa-user',User::class);
        yield MenuItem::linkToUrl('Homepage', 'fa fa-home',$this->generateUrl('app_front'));
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if(!$user instanceof User){
            throw new \Exception('wrong user');
        }
        return parent::configureUserMenu($user)
            ->setAvatarUrl($user->getAvatarUrl())
            ->setMenuItems([
                MenuItem::linkToUrl('My Profile', 'fas fa-user',$this->generateUrl('app_profile'))
            ])
            ;
    }


    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

}
