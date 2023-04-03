<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add("category");
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['published_at' => 'DESC'])
            ->renderContentMaximized()
            ->renderSidebarMinimized();
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('author'),
            TextField::new('title'),
            TextareaField::new('description')->hideOnIndex(),
            TextField::new('source'),
            TextField::new('image')->hideOnIndex(),
            TextField::new('category'),
            TextField::new('country'),
            TextField::new('language'),
            DateTimeField::new('published_at'),
        ];
    }
}
