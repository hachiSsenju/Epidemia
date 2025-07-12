<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Zone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomZone', TextType::class, [
                'label' => 'Nom de la zone',
                'attr' => [
                    'placeholder' => 'Entrez le nom de la zone',
                    'class' => 'form-control form-group',
                ],
            ])
           
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nomPays',
                'attr' => [
                    'class' => 'form-control form-group',
                ],
            ])
            ->add('valider',SubmitType::class, [
                'attr' => [
                    'value' => 'Ajouter',
                    'class' => 'form-control form-group btn btn-success',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zone::class,
        ]);
    }
}
