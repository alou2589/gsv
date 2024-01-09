<?php

namespace App\Form;

use App\Entity\Emargement;
use App\Entity\Affectation;
use App\Entity\FeuillePresence;
use App\Entity\EtatTempsPresence;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmargementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat_tp', EntityType::class, [
                'class' => EtatTempsPresence::class,
                'choice_label' => 'nom_etat_tp',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function ($affectation) {
                        return $affectation->getVolontaireStatut()->getVolontaire()->getPrenom().' '.$affectation->getVolontaireStatut()->getVolontaire()->getNom().' '.$affectation->getVolontaireStatut()->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('feuille', EntityType::class, [
                'class' => FeuillePresence::class,
                'choice_label' => 'numero_feuille',
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emargement::class,
        ]);
    }
}
