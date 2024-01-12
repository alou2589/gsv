<?php

namespace App\Form;

use App\Entity\Emargement;
use App\Entity\Affectation;
use App\Entity\FeuillePresence;
use App\Entity\EtatTempsPresence;
use Doctrine\ORM\EntityRepository;
use App\Entity\ServiceDepartemental;
use Symfony\Component\Form\AbstractType;
use App\Repository\AffectationRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FPEmargementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dd($this->getParameter('FPEmargementType.php'));
        
        $builder
            ->add('etat_tp', EntityType::class, [
                'label' => false,
                'class' => EtatTempsPresence::class,
                'choice_label' => 'nom_etat_tp',
                'attr'=>['style'=>'width:100%','class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emargement::class,
            'id_sdc'=>null,
        ]);
    }
}
