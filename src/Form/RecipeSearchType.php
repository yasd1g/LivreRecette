<?php

namespace App\Form;

use App\Entity\RecipeSearch;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeSearchType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('q',
                TextType::class,[

                    'label' => "Rechercher une recette",
                    'required' => false,
                    'attr' => [
                        'placeholder' => " Rechercher"
                    ]
                ])
            ->add('category',
                ChoiceType::class,[
                    'choices' => [
                        'Toutes catégories' => null,
                        'Sucré' => 2,
                        'Salé' => 1,
                    ],
                    'label' => 'Catégorie',
                    'required' => false
                ])
//            ->add('rating',
//                IntegerType::class,
//                $this->getConfiguration("Note","",
//                    [
//                        'attr' => [
//                            'min' => 1,
//                            'max' => 5,
//                            'step' => 1
//                        ],
//                        'required' => false,
//                    ])
//            )
            ->add('difficulty',
                IntegerType::class,
                $this->getConfiguration("Difficulté","1 pour facile, 4 pour très difficile",
                    [
                        'attr' => [
                            'min' => 1,
                            'max' => 4,
                            'step' => 1
                        ],
                        'required' => false,
                    ])

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecipeSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
