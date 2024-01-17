<?php

namespace App\Form;
use App\Entity\BilanVolontaireSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BilanVolontaireSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('minDate', DateType::class, [ 
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('maxDate', DateType::class, [ 
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>BilanVolontaireSearch::class,
            'method'=>'get',
            'csrf_protection'=>false,
        ]);
    }
}