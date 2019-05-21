<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Airport;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aeroport_start', EntityType::class, [
                'class' => Airport::class,
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-control'],
                'label_format' => ' ',

                ])
                ->add('aeroport_end',EntityType::class, [
                    'class' => Airport::class,
                    'choice_label' => 'libelle',
                    'attr' => ['class' => 'form-control'],
                    'label_format' => ' ',
            ])
            ->add('hour_start',DateType::class,[
                'placeholder'=>'hour de départ',
                'required'=>true,
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'label_format' => ' ',
            ])
            ->add('enregistrer', SubmitType::class, [
                "label"=>"Rechercher",
                "attr"=>["class"=>"btn btn-primary"],
                "attr"=>["class"=>"form-control"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
