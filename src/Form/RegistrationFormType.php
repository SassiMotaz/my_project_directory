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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
                'attr' => ['placeholder' => 'Entrez votre nom d\'utilisateur'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un nom d\'utilisateur.'),
                    new Length(
                        min: 3,
                        max: 50,
                        minMessage: 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('email', null, [
                'label' => 'Adresse e-mail institutionnelle',
                'attr' => ['placeholder' => 'Adresse e-mail'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir une adresse e-mail.'),
                    new Regex(
                        pattern: '/^[a-zA-Z]+\.[a-zA-Z]+@(etudiant-)?issit\.utm\.tn$/',
                        message: 'L’adresse e-mail doit être au format nom.prenom@etudiant-issit.utm.tn ou nom.prenom@issit.utm.tn.'
                    ),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Saisissez un mot de passe'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez saisir un mot de passe.'),
                    new Length(
                        min: 6,
                        max: 4096,
                        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmez le mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Confirmez votre mot de passe'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez confirmer votre mot de passe.'),
                    new Length(
                        min: 6,
                        max: 4096,
                        minMessage: 'La confirmation doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('accountType', ChoiceType::class, [
                'choices' => [
                    'Étudiant' => 'etudiant',
                    'Professeur' => 'professeur',
                    'Administration' => 'administration',
                ],
                'label' => 'Type de compte',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J’accepte les conditions d’utilisation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les conditions d’utilisation.'),
                ],
            ]);

        // Validation confirmPassword
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $password = $form->get('plainPassword')->getData();
            $confirm = $form->get('confirmPassword')->getData();

            if ($password !== $confirm) {
                $form->get('confirmPassword')->addError(new FormError('Les mots de passe ne correspondent pas.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
