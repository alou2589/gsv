<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\FeuillePresence;
use App\Entity\ServiceDepartemental;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FeuillePresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_feuille', DateTimeType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de Création',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('active', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'attr'=>['class'=>'js-switch']
                
            ])
            ->add('service_departemental', EntityType::class, [
                'class' => ServiceDepartemental::class,
                'choice_label' => 'nom_sdc',
            ])
        ;
        $builder->get('active')
            ->addModelTransformer(new CallbackTransformer(
                function ($activeAsString) {
                    // transform the string to boolean
                    return (bool)(int)$activeAsString;
                },
                function ($activeAsBoolean) {
                    // transform the boolean to string
                     return (string)(int)$activeAsBoolean;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeuillePresence::class,
        ]);
    }
}
