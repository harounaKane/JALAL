<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', TextType::class, [
                "label" => "Auteur",
                "attr" => [
                    "placeholder" => "Nom et prénom",
                    "minlength" => 4,
                    "maxlength" => 50
                ]
            ])
            ->add('comment', TextareaType::class, [
                "label" => "Commentaire",
                "attr" => [
                    "placeholder" => "Tapez votre commentaire ici",
                    "minlength" => 2,
                    "maxlength" => 200
                ]
            ])
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
