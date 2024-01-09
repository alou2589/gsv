<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Contrat;
use App\Entity\Volontaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de début',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('date_fin', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de fin ',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('volontaire', EntityType::class, [
                'class' => Volontaire::class,
                'choice_label' => function (Volontaire $volontaire){
                    return $volontaire->getPrenom().' '.$volontaire->getNom().'-'.$volontaire->getNumeroCin();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
