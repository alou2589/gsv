<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\BilanVolontaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BilanVolontaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mois', ChoiceType::class, [
                'choices'=>[
                    'Janvier'=>'01',
                    'Février'=>'02',
                    'Mars'=>'03',
                    'Avril'=>'04',
                    'Mai'=>'05',
                    'Juin'=>'06',
                    'Juillet'=>'07',
                    'Août'=>'08',
                    'Septembre'=>'09',
                    'Octobre'=>'10',
                    'Novembre'=>'11',
                    'Décembre'=>'12',
                ]
            ])
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function (Affectation $affectation) {
                    return $affectation->getVolontaireStatut()->getVolontaire()->getPrenom().' '.$affectation->getVolontaireStatut()->getVolontaire()->getNom().' '.$affectation->getVolontaireStatut()->getMatricule();

                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BilanVolontaire::class,
        ]);
    }
}
