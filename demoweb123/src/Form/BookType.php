<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
            [
                'label' => "Book Title",
                'required' => true,
                'attr' => [
                    'maxlength' => 30,
                    'minlength' => 5
                ]
            ])
            ->add('year', IntegerType::class,
            [
                'attr' => [
                    'max' => 2022,
                    'min' => 2000
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'currency' => 'USD'
            ])
            ->add('quantity')
            ->add('image')
            ->add('authors', EntityType::class,
            [
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true, //default: false
                'expanded' => false // checkbox
                                   //default: false => drop-down
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
