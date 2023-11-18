<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RozetkaAccountsAdmin extends AbstractAdmin
{
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $form): void
    {
        $form
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('seller_fio', TextType::class)
            ->add('seller_email', EmailType::class)
            ->add('market_id', IntegerType::class)
            ->add('market_title', TextType::class);
    }

    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('username')
            ->add('password');
    }

    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $list): void
    {
        $list
            ->addIdentifier('username')
            ->addIdentifier('password');
    }

    protected function configureShowFields(\Sonata\AdminBundle\Show\ShowMapper $show): void
    {
        $show
            ->add('username')
            ->add('password');
    }
}