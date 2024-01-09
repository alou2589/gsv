<?php

namespace App\Form;

use App\Entity\Regions;
use App\Entity\ServiceRegional;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceRegionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_src')
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'choice_label' => 'nom_region',
                'attr' => ['class'=>'js-example-basic-single'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceRegional::class,
        ]);
    }
}
