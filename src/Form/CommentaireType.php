<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $article = new Article();
        $builder
            ->add('user', TextType::class, [
                "label" => "Auteur",
                "attr" => [
                    "placeholder" => "Nom et prénom",
                    "minlength" => 4,
                    "maxlength" => 50,
                    "class" => "bg_input",
                ]
            ])
            ->add('comment', TextareaType::class, [
                "label" => "Commentaire",
                "attr" => [
                    "placeholder" => "Tapez votre commentaire ici",
                    "minlength" => 2,
                    "maxlength" => 200,
                    "rows" => 10,
                    "class" => "bg_input",
                ]
            ])
//            ->add('article', EntityType::class, [
//                "class" => Article::class,
//                "data" => function($article){
//                    return $article->getId();
//                }
//            ])
            ->add('Poster', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
