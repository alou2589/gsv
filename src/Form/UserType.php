<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('matricule', TextType::class)
            ->add('pseudo', TextType::class)
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'multiple'=>true,
                'choices' => [
                    'Super Admin' => 'ROLE_SUPERADMIN',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'attr'=>['class'=>'js-example-basic-multiple js-states', 'id'=>'id_label_multiple'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
