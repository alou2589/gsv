<?php

namespace App\Form;

use App\Entity\Departements;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_departement')
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'choice_label' => 'nom_region',
                'attr'=>['class'=>'js-example-basic-single js-states']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departements::class,
        ]);
    }
}
