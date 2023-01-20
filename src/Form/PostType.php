<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'row_attr' => ["class" => "mb-3"],
                'attr' => [
                    "class" => "form-control",
                    "placeholder" => "Indiquer le titre de l'article"
                ],
                'help' => "Le titre ne doit pas avoir plus de <b>100</b> caractères",
                'help_attr' => ["class" => "small"],
                'help_html' => true,
                'label' => 'Titre: '
            ])
            ->add('body', TextareaType::class, [
                'attr' => [
                    "class" => "form-control",
                    "placeholder" => "Contenu de l'article"
                ],
                'help' => "Format HTML autorisé",
                'help_attr' => ["class" => "small"],
                'label' => 'Contenu: '
            ])
            ->add('author', EntityType::class, [
                'label' => 'Auteur: ',
                'attr' => ["class" => "form-select"],
                'row_attr' => ["class" => "mb-3"],
                'placeholder' => "Choisissez un auteur",
                'class' => Author::class,
                'choice_label' => function(Author $author) {
                    return $author->getFullname();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'required' => false
        ]);
    }
}
