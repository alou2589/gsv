<?php

namespace App\Form;

use App\Entity\BilanVolontaire;
use App\Entity\BulletinVolontaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulletinVolontaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bilan_volontaire', EntityType::class, [
                'class' => BilanVolontaire::class,
                'choice_label' => function (BilanVolontaire $bilanVolontaire) {
                    return $bilanVolontaire->getAffectation()->getVolontaireStatut()->getVolontaire()->getPrenom().' '.$bilanVolontaire->getAffectation()->getVolontaireStatut()->getVolontaire()->getNom().' '.$bilanVolontaire->getAffectation()->getVolontaireStatut()->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BulletinVolontaire::class,
        ]);
    }
}
