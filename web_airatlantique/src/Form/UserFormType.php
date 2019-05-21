<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                    "attr"=>["class"=>"form-control"],
                'label_format' => ' ',
                ])
            ->add('name', TextType::class, [
                "attr"=>["class"=>"form-control"],
                'label_format' => ' ',
            ])
            ->add('surname', TextType::class, [
                "attr"=>["class"=>"form-control"],
                'label_format' => ' ',
            ])
            ->add('password', PasswordType::class, [
                "attr"=>["class"=>"form-control"],
                'label_format' => ' ',
            ])
            ->add('birthdate', DateType::class, [
                'required'=>true,
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'label_format' => 'Date de naissance',
            ])
            ->add('enregistrer', SubmitType::class, [
                "label"=>"Enregistrer",
                "attr"=>["class"=>"btn btn-primary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
