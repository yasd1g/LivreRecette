<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',
            TextType::class,
                $this->getConfiguration("Prénom","")
            )
            ->add('lastName',
                TextType::class,
                $this->getConfiguration("Nom","")
            )
            ->add('phone',
                textType::class,
                $this->getConfiguration("Téléphone","")
            )
            ->add('email',
                EmailType::class,
                $this->getConfiguration("Email","")
            )
            ->add('message',
                TextareaType::class,
                $this->getConfiguration("Votre message","Veuillez taper votre message ...")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
