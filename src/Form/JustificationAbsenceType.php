<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Affectation;
use App\Entity\JustificationAbsence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class JustificationAbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_justificatif', ChoiceType::class, [
                'choices'=>[
                    'Certificat Médical'=>'Certificat Médical',
                    'Certificat de Mariage'=>'Certificat de Mariage',
                    'Justification Verbale'=>'Justification Verbale',
                    'Décès'=>'Décès',
                    'Baptème'=>'Baptème',
                    'Autre Justificatif'=>'Autre Justificatif',
                ]
            ])
            ->add('nb_jours_absence',NumberType::class,[
                'attr'=>['class'=>'number']
            ])
            ->add('date_debut', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de Début',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('date_fin', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de Fin',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('upload_justificatif', FileType::class, [
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
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Charger un document PDF',
                    ])
                ],
            ])
            ->add('status_validation', ChoiceType::class, [
                'choices'=>[
                    'Satisfait'=>'Satisfait',
                    'Rejeter'=>'Rejeter',
                ]
            ])
            ->add('date_justification', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date Justification',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function (Affectation $affectation) {
                    if($affectation->getCartePros()->toArray()==null){
                        return $affectation->getVolontaireStatut()->getVolontaire()->getPrenom().' '.$affectation->getVolontaireStatut()->getVolontaire()->getNom().' '.$affectation->getVolontaireStatut()->getMatricule();
                    }
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JustificationAbsence::class,
        ]);
    }
}
