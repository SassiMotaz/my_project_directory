<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un nom d\'utilisateur.'),
                    new Length(min: 3, max: 50),
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un email.'),
                    new Regex(
                        pattern: '/^[a-zA-Z]+\.[a-zA-Z]+@(etudiant-|admin-)?issit\.utm\.tn$/',
                        message: 'Email doit être nom.prenom@etudiant-issit.utm.tn, nom.prenom@issit.utm.tn ou nom.prenom@admin-issit.utm.tn'
                    ),
                ],
            ])            
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un mot de passe.'),
                    new Length(min: 6, max: 4096),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(message: 'Veuillez confirmer le mot de passe.'),
                    new Length(min: 6, max: 4096),
                ],
            ])
            ->add('accountType', ChoiceType::class, [
                'choices' => [
                    'Étudiant' => 'etudiant',
                    'Professeur' => 'professeur',
                    'Administration' => 'administration',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'registration_item',
        ]);
    }
}
