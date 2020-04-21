<?php

namespace App\Form;

use App\Entity\Recipe;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration('Titre',"Tapez le titre de votre recette")
                )
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration("Adresse web", "Tapez l'adresse web(automatique)",
                    [
                        'required' => false
                    ]
                )
            )
            ->add('introduction',
                TextType::class,
                $this->getConfiguration('Introduction',"Donnez une description globale")
            )
            ->add('category',
                ChoiceType::class,[
                'choices' => [
                    'Sucré' => 0,
                    'Salé' => 1,
                ],
                    'label' => "Catégorie"
            ])
            ->add('coverImage',
                UrlType::class,
                $this->getConfiguration("URL de l'image", "Donnez l'adresse d'une image qui donne vraiment envie")
            )
            ->add('difficulty',
                IntegerType::class,
                $this->getConfiguration("difficulté sur 4","Veuillez indiquer la difficulté de 0 à 4",
                    [
                        'attr' => [
                            'min' => 0,
                            'max' => 4,
                            'step' => 1
                        ]
                    ])

            )
            ->add('realization',
                CKEditorType::class,
                $this->getConfiguration("Préparation", "Décrivez votre mode opératoire"
                )
            )
            ->add('ingredients',
                CKEditorType::class,
                $this->getConfiguration("Liste des ingrédients", "Listez vos ingrédients ")
            )
            ->add('cookingTime',
                IntegerType::class,
                $this->getConfiguration("Temps de cuisson en minutes","",
                    [
                        'attr' => [
                            'min' => 0,
                            'max' => 250,
                            'step' => 5
                        ]
                    ])

            )
            ->add('preparationTime',
                IntegerType::class,
                $this->getConfiguration("Temps de préparation en minutes","",
                    [
                        'attr' => [
                            'min' => 0,
                            'max' => 250,
                            'step' => 1
                        ]
                    ])

            )
            ->add('thermostat',
                IntegerType::class,
                $this->getConfiguration("Thérmostat de cuisson en °C","",
                    [
                        'attr' => [
                            'min' => 50,
                            'max' => 250,
                            'step' => 10
                        ]
                    ])

            )
            ->add('nbOfPersons',
                IntegerType::class,
                $this->getConfiguration("pour combien de personnes","",
                    [
                        'attr' => [
                            'min' => 1,
                            'max' => 10,
                            'step' => 1
                        ]
                    ])

            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]

            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
