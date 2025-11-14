<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ pour le texte de la question
            ->add('texte', null, [
                'label' => 'Texte de la question',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le texte de la question',
                ],
            ])
            // Sélection du quiz associé
            ->add('quiz', EntityType::class, [
                'class' => Quiz::class,
                'choice_label' => 'titre', // Affiche le titre du quiz au lieu de l'ID
                'label' => 'Quiz associé',
                'placeholder' => 'Choisir un quiz', // Pour un select vide
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class, // Lie le formulaire à l'entité Question
        ]);
    }
}
