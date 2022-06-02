<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->onlyOnIndex(),
            TextField::new('title'),
            TextEditorField::new('description'),
            NumberField::new('bedrooms'),
            ChoiceField::new('type')->setChoices([
                'Condo' => 'Condo',
                'Villa' => 'Villa',
                'Bungalow' => 'Bungalow',
            ]),
            MoneyField::new('min_price')
            ->setCurrency('THB'),
            AssociationField::new('pictures')
            ->setFormTypeOption('choice_label','fileName'),
        ];
    }

}
