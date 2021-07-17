<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon adresse Email'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon prénom'
            ])
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mon mot passe actuel'
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Nouveau Mot de passe ',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',   'attr' => ['placeholder' => 'Mon nouveau mot de passe']],
                'second_options' => ['label' => 'Veuillez confirmer votre mot de passe',   'attr' => ['placeholder' => 'Confirmer mon nouveau mot de passe']],
            ])->add('submit', SubmitType::class, [
                'label' => "Mettre à jour"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
