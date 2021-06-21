<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url',  TextType::class, [
                "label" => "URL",
                "attr" => [
                    "placeholder" => "Collez votre URL ici",
                ],
                'required' => false
            ])
            ->add('nom', FileType::class, [
                "label" => "Fichier",
                "attr" => [
                    "placeholder" => "Importez votre fichier ici",
                ],               
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                'multiple' => true
            ])
            ->add('legende', TextType::class, [
                "label" => "Légende",
                "attr" => [
                    "placeholder" => "Légende du media",
                    "required" => false,
                    "maxlength" => 150
                ]
            ])
            ->add('texte', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                    "placeholder" => "Texte complémentaire du média",
                    "required" => false,
                    "maxlength" => 150,
                    "rows" => 5
                ]
            ])
            ->add('ordre',  HiddenType::class)

           ->add("Ajouter", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
