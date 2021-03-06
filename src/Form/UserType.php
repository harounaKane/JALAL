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
                "help" => '2 à 30 caractères',
                "attr" => [
                    "placeholder" => "Prénom",
                    "minlength" => 2,
                    "maxlength" => 30
                ]
            ])
            ->add('last_name', TextType::class, [
                "label" => "Nom",
                "help" => '2 à 30 caractères',
                "attr" => [
                    "placeholder" => "Nom",
                    "minlength" => 2,
                    "maxlength" => 30
                ]
            ])
            ->add('mail', EmailType::class, [
                "label" => "Mail",
                "help" => '8 à 40 caractères',
                "attr" => [
                    "placeholder" => "votre.adresse@mail.fr",
                    "minlength" => 8,
                    "maxlength" => 40,
                    "pattern" => "[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                ]
            ])
            ->add('login', TextType::class, [
                "label" => "Login",
                "help" => '4 à 15 caractères, pas de caractères spéciaux',
                "attr" => [
                    "placeholder" => "Login",
                    "minlength" => 4,
                    "maxlength" => 15,
                    "pattern" => "^[A-Za-z0-9]+"
                ]
            ])
            ->add('country', TextType::class, [
                "label" => "Pays",
                "help" => '',
                'attr'      => [
                    'list'  => 'pays'
                    ]
            ])
//            ->add('country', CountryType::class, [
//                "label" => "Pays résidence"
//            ])
            ->add('avatar', FileType::class, [
                "label" => "Avatar",
                "data_class" => null,
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "help" => '255 caractères maximum',
                "attr" => [
                    "placeholder" => "Courte description",
                    "rows" => 2,
                    "maxlength" => 255
                ]
            ]);
        
        if($options["usePassword"]){
            $builder->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                "first_options" => ['label' => "Mot de passe",
                    'help' => '6 à 10 caractères, au moins une majuscule et un chiffre',
                    'attr' => ['minlength' => 6, 'maxlength' => 10, 'pattern' => "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,10}"]],
                "second_options" => ['label' => "Confirmation",
                    'attr' => ['minlength' => 6, 'maxlength' => 10]]
            ]);
        }

        $builder->add("Enregistrer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'usePassword' => true
        ]);
    }

}
