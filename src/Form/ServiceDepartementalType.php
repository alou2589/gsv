<?php

namespace App\Form;

use App\Entity\Departements;
use App\Entity\ServiceDepartemental;
use App\Entity\ServiceRegional;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceDepartementalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_sdc')
            ->add('service_regional', EntityType::class, [
                'class' => ServiceRegional::class,
                'choice_label' => 'nom_src',
                'attr' => ['class'=>'js-example-basic-single'],
            ])
            ->add('departement', EntityType::class, [
                'class' => Departements::class,
                'choice_label' => 'nom_departement',
                'attr' => ['class'=>'js-example-basic-single'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceDepartemental::class,
        ]);
    }
}
