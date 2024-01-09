<?php

namespace App\Form;

use App\Entity\Volontaire;
use App\Entity\StatutVolontaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StatutVolontaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('date_recrutement', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('volontaire', EntityType::class, [
                'class' => Volontaire::class,
                'choice_label' => function(Volontaire $volontaire){
                    return $volontaire->getPrenom()." ".$volontaire->getNom()." ".$volontaire->getTelephone();
                },
                'attr' => ['class'=>'js-example-basic-single'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatutVolontaire::class,
        ]);
    }
}
