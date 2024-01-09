<?php

namespace App\Form;

use App\Entity\Poste;
use App\Entity\Affectation;
use App\Entity\StatutVolontaire;
use App\Entity\ServiceDepartemental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_affectation', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('volontaire_statut', EntityType::class, [
                'class' => StatutVolontaire::class,
                'choice_label' => function(StatutVolontaire $statutVolontaire){
                    return $statutVolontaire->getVolontaire()->getPrenom()." ".$statutVolontaire->getVolontaire()->getNom()." ".$statutVolontaire->getMatricule();
                },
            ])
            ->add('service_departemental', EntityType::class, [
                'class' => ServiceDepartemental::class,
                'choice_label' => 'nom_sdc',
            ])
            ->add('poste', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'nom_poste',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
