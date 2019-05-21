<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('type',ChoiceType::class, [
                'choices' => $option['classes'],
                'choice_label' => 'Libelle',
                'placeholder' => 'Choisissez la classe',
                'attr' => ['class' => 'form-control']
            ])
            ->add('enregistrer', SubmitType::class, [
                "label"=>"Enregistrer",
                "attr"=>["class"=>"form-control btn btn-primary"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'classes' => null
        ]);
    }
}
