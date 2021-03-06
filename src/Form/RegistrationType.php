<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom ..."))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille..."))
            ->add('description', TextareaType::class, $this->getconfiguration("Description détaillée", "C'est le moment de vous présenter en détails ! (exemple: J'habite Mont de marsan et je souhaite vous faire partager mes recettes.) Votre profil est modifiable à tout moment."))
            ->add('email', EmailType::class, [
                'label' => "Email",
                'required' => true,
                'attr' => [
                    'autofocus' => true
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe saisis ne correspondent pas.",
                'required' => true,
                'first_options' => [
                    'label' => "Mot de passe",
                    'label_attr' => [
                        'title' => 'Pour des raisons de sécurité, votre mot de passe doit contenir au minimum 12 caractères dont 1 lettre majuscule, 1 lettre minuscule, 1 chiffre et un caractère spécial (dans un ordre aléatoire).' 
                    ],
                    'attr' => [
                        'pattern' => "^(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ý])(?=.*[0-9])(?=.*[^a-zà-ÿA-ZÀ-Ý0-9]).{12,}$",
                        'title' => "Pour des raisons de sécurité, votre mot de passe doit contenir au minimum 12 caractères dont 1 lettre majuscule, 1 lettre minuscule, 1 chiffre et un caractère spécial (dans un ordre aléatoire).",
                        'maxlength' => 255
                    ]
                ],
                'second_options' => [
                    'label' => "Confirmer le mot de passe",
                    'label_attr' => [
                        'title' => 'Confirmer le mot de passe'
                    ],
                    'attr' => [
                        'pattern' => "^(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ý])(?=.*[0-9])(?=.*[^a-zà-ÿA-ZÀ-Ý0-9]).{12,}$",
                        'title' => "Confirmer le mot de passe",
                        'maxlength' => 255
                    ]
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "J'accepte les conditions d'utilisations de ce site.",
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions de ce site pour vous inscrire.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
