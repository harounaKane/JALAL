<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', EntityType::class, [
                "label" => "Catégorie",
                "class" => Categorie::class,
                "choice_label" => function ($category) {
                    return $category->getDesignation() ;
                }
            ])
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
            ->add('content', TextareaType::class, [
                "label" => "Contenu",
                "attr" => [
                    "placeholder" => "Contenu",
                    "rows" => 5,
                    "maxlength" => 20000
                ]
            ])
            ->add('main_image', FileType::class, [
                "label" => "Image principale",
                'data_class' => null,
                'required' => false
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
