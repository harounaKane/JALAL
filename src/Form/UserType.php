<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                "label" => "Civilité",
                'choices' => [
                    'Femme' => 'femme',
                    'Homme' => 'homme'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('first_name', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Prénom",
                    "minlength" => 2,
                    "maxlength" => 30
                ]
            ])->add('last_name', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Nom",
                    "minlength" => 2,
                    "maxlength" => 30
                ]
            ])
            ->add('mail', EmailType::class, [
                "label" => "Mail",
                "attr" => [
                    "placeholder" => "votre.adresse@mail.fr",
                    "minlength" => 8,
                    "maxlength" => 40
                ]
            ])
            ->add('login', TextType::class, [
                "label" => "Login",
                "attr" => [
                    "placeholder" => "Login",
                    "minlength" => 4,
                    "maxlength" => 15
                ]
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => ['label' => "Mot de passe",
                    'attr' => ['minlength' => 6, 'maxlength' => 10]],
                "second_options" => ['label' => "Confirmation",
                    'attr' => ['minlength' => 6, 'maxlength' => 10]]
            ])
            ->add('country', TextType::class, [
                "label" => "Pays résidence",
                'attr'      => [
                    'list'        => 'pays',
                    'value' => "Sénégal"
                    ]
            ])
//            ->add('country', CountryType::class, [
//                "label" => "Pays résidence"
//            ])
            ->add('avatar', FileType::class, [
                "label" => "Image profil",
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                "label" => "Contenu",
                "attr" => [
                    "placeholder" => "Courte description",
                    "rows" => 2,
                    "maxlength" => 255
                ]
            ])
            ->add("Enregistrer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
