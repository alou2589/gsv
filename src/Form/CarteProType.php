<?php

namespace App\Form;

use App\Entity\CartePro;
use App\Entity\Affectation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CarteProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function (Affectation $affectation) {
                    if($affectation->getCartePros()->toArray()==null){
                        return $affectation->getVolontaireStatut()->getVolontaire()->getPrenom().' '.$affectation->getVolontaireStatut()->getVolontaire()->getNom().' '.$affectation->getVolontaireStatut()->getMatricule();
                    }
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_delivrance', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de Délivrance',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('date_expiration', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date d\'Expiration',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('photo_volontaire', FileType::class, [
                'label' =>false,
    
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Charger une image',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartePro::class,
        ]);
    }
}
