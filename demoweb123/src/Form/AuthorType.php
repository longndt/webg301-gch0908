<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('birthday', DateType::class,
            [
                'widget' => 'single_text'
            ])
            ->add('address', ChoiceType::class,
            [
                'choices' => [
                    'Ha Noi' => 'Ha Noi',
                    'HCM City' => 'HCM City',
                    'Da Nang' => 'Da Nang',
                    'Can Tho' => 'Can Tho'
                ],
                'expanded' => true //false: drop-down
                                    //true: radio button
            ]) 
            ->add('image')
            //->add('books')
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
