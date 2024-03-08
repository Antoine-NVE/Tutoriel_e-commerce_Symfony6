<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre nom"),
                    new Length([
                        "min" => 3,
                        "max" => 50,
                        "minMessage" => "Votre nom doit contenir {{ limit }} caractères minimum",
                        "maxMessage" => "Votre nom doit contenir {{ limit }} caractères maximum",
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre prénom"),
                    new Length([
                        "min" => 3,
                        "max" => 50,
                        "minMessage" => "Votre prénom doit contenir {{ limit }} caractères minimum",
                        "maxMessage" => "Votre prénom doit contenir {{ limit }} caractères maximum",
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "E-mail",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre e-mail"),
                    new Email(message: "E-mail invalide")
                ]
            ])
            ->add('address', TextType::class, [
                "label" => "Adresse",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre addresse"),
                    new Length([
                        "min" => 3,
                        "max" => 50,
                        "minMessage" => "Votre ville doit contenir {{ limit }} caractères minimum",
                        "maxMessage" => "Votre ville doit contenir {{ limit }} caractères maximum",
                    ])
                ]
            ])
            ->add('zipcode', TextType::class, [
                "label" => "Code postal",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre code postal"),
                    new Length([
                        "min" => 5,
                        "max" => 5,
                        "exactMessage" => "Votre code postal doit contenir exactement {{ limit }} caractères"
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville",
                "constraints" => [
                    new NotBlank(message: "Veuillez saisir votre ville"),
                    new Length([
                        "min" => 3,
                        "max" => 50,
                        "minMessage" => "Votre ville doit contenir {{ limit }} caractères minimum",
                        "maxMessage" => "Votre ville doit contenir {{ limit }} caractères maximum",
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 20,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} caractères minimum',
                        "maxMessage" => "Votre mot de passe doit faire {{ limit }} caractères maximum"
                    ]),
                ],
                "label" => "Mot de passe"
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les RGPD',
                    ]),
                ],
                "label" => "Accepter les RGPD..."
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
