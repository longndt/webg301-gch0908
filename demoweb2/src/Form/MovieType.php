<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('image', TextType::class)
            ->add('year', IntegerType::class,
            [
                'label' => 'Published Year',
                'required' => true,
                'attr' =>
                [
                    'min' => 2010,
                    'max' => 2022
                ]
            ])
            ->add('genres', EntityType::class,
            [
                'label' => 'Movie genre',
                'required' => true,
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false
                /* expanded: true => checkbox
                   expanded: false => dropdown */
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
