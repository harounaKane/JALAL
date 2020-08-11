<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre Principal",
                "attr" => [
                    "placeholder" => "Titre Principal",
                    "minlength" => 2,
                    "maxlength" => 100
                ]
            ])
            ->add('secondary_title', TextType::class, [
                "label" => "Titre Secondaire",
                "attr" => [
                    "placeholder" => "Titre Secondaire",
                    "minlength" => 2,
                    "maxlength" => 100
                ]
            ])
            ->add('content', TextType::class, [
                "label" => "Contenu",
                "attr" => [
                    "placeholder" => "Contenu",
                    "minlength" => 2,
                    "maxlength" => 5000
                ]
            ])
            ->add('main_image', FileType::class, [
                "label" => "Image principale",
                'required' => true
            ])
            ->add("Ajouter", SubmitType::class)    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
