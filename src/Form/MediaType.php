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
            ->add('nom', FileType::class, [
                "label" => "Votre fichier",
                'data_class' => null,
                'required' => false
            ])
            ->add('legende', TextType::class, [
                "label" => "Légende",
                "attr" => [
                    "placeholder" => "légende fichier",
                    "required" => false,
                    "maxlength" => 255
                ]
            ])
            ->add('texte', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                    "placeholder" => "texte complémentaire du média",
                    "required" => false,
                    "maxlength" => 500,
                    "rows" => 5
                ]
            ])
            ->add('ordre',  HiddenType::class)
            // ->add('ordre', ChoiceType::class, [
            //     "label" => "Ordre",
            //     "choices" => [
            //         "1" => 1,
            //         "2" => 2,
            //         "3" => 3,
            //         "4" => 4,
            //         "5" => 5
            //     ]
            // ])
            ->add('type',  HiddenType::class)
            // ->add('type',  ChoiceType::class, [
            //     "label" => "Type du média",
            //     "choices" => [
            //         "Vidéo" => "video",
            //         "Image" => "image",
            //         "Audio" => "audio"
            //     ]
            // ])
        //    ->add("Ajouter", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
