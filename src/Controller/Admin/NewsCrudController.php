<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\Security\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;

class NewsCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        $actions->disable(Action::NEW, Action::EDIT);

        if (!in_array(User::ROLE_ADMIN, $this->security->getUser()->getRoles())) {
            $actions->disable(Action::DELETE);
        }

        return $actions;
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
