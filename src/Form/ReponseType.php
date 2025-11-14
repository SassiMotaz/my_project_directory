<?php

namespace App\Form;

use App\Entity\Reponse;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', TextType::class, [
                'label' => 'Réponse',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le texte de la réponse',
                ],
            ])
            ->add('correcte', CheckboxType::class, [
                'label' => 'Correcte',
                'required' => false,
            ])
            ->add('justification', TextareaType::class, [
                'label' => 'Justification',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 2,
                    'placeholder' => 'Justification de la réponse',
                ],
            ])
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'texte', // Affiche le texte de la question
                'label' => 'Question associée',
                'placeholder' => 'Choisir une question',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
