<?php

namespace App\Form;

use App\Entity\Volontaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VolontaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('genre', ChoiceType::class, [
                'choices'=>[
                    'Homme'=>'Homme',
                    'Femme'=>'Femme',
                ]
            ])
            ->add('date_naissance', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('lieu_naissance', TextType::class)
            ->add('numero_cin', TextType::class)
            ->add('adresse', TextareaType::class)
            ->add('telephone', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Volontaire::class,
        ]);
    }
}
