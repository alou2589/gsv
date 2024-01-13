<?php

namespace App\Form;

use App\Entity\EmargementSearch;
use App\Entity\ServiceDepartemental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmargementSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chosenDate', DateType::class, [ 
                'widget' => 'single_text',
                'label'=>false,
                'required'=>false,
                'html5'=>false,
                'format'=>'mm-yyyy',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('chosenSdc', EntityType::class, [
                'class' => ServiceDepartemental::class,
                'choice_label' => 'nom_sdc',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmargementSearch::class,
            'method'=>'get',
            'csrf_protection'=>false,
        ]);
    }
}
