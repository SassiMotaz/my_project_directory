<?php

namespace App\Form;

use App\Entity\ForumPost;
use App\Entity\ForumReply;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumReplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ForumReply::class,
            'csrf_protection' => true,        // active CSRF
            'csrf_field_name' => '_token',    // champ token
            'csrf_token_id'   => 'forum_post_item', // identifiant unique du token
        ]);
    }
}
