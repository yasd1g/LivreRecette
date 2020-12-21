<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'rating',
                IntegerType::class,
                $this->getConfiguration("Note", "Entrez votre note pour cette recette !",
                    [
                        'attr' => [
                            'min' => 1,
                            'max' => 5,
                            'step' =>1
                        ]
                    ])
            )
            ->add(
                'content',
                TextareaType::class,
                $this->getConfiguration("Commentaire", "Entrer votre votre commentaire ...")
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
