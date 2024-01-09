<?php

namespace App\Form;

use App\Entity\Fichiers;
use App\Entity\TypeFichier;
use App\Entity\StatutVolontaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FichiersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_fichier', TextType::class)
            ->add('fichier', FileType::class, [
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
            ->add('type_fichier', EntityType::class, [
                'class' => TypeFichier::class,
                'choice_label' => 'nom_type_fichier',
            ])
            ->add('volontaire_statut', EntityType::class, [
                'class' => StatutVolontaire::class,
                'choice_label' => function(StatutVolontaire $statutVolontaire){
                    return $statutVolontaire->getVolontaire()->getPrenom()." ".$statutVolontaire->getVolontaire()->getNom()." ".$statutVolontaire->getMatricule();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fichiers::class,
        ]);
    }
}
