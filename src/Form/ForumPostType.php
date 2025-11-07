<?php

namespace App\Form;

use App\Entity\ForumPost;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , null, [
                'label' => 'Titre du post',
                'attr' => [
                    'placeholder' => 'Ecrite le titre de ton post ici...'
                ],
            ])
            ->add('content', null, [
                'label' => 'Contenu du post',
                'attr' => [
                    'placeholder' => 'Rédige le contenu de ton post ici...'
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ForumPost::class,
        ]);
    }
}
