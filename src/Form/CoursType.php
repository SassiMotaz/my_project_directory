<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du cours',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Entrez le titre du cours'
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu du cours',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'rows' => 6,
                    'placeholder' => 'Rédigez le contenu ou la description du cours...'
                ],
            ])

            // file path is lien 
            ->add('filePath', TextType::class, [
                'label' => 'Fichier du cours (PDF, DOCX, etc.)',
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
            ])      
            ->add('Lien', TextType::class, [
                'label' => 'Lien du cours (URL)',
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
            ])
                 
            ->add('createdat', null, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
            ])
            ->add('prof', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Professeur',
                'attr' => [
                    'class' => 'form-select mb-3'
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
