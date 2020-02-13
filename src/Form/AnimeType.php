<?php

namespace App\Form;

use App\Entity\Anime;
use App\Entity\Kind;
use App\Entity\Type;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AnimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('published')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name'
            ])
            ->add('kind', EntityType::class, [
                'class' => Kind::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('status', EntityType::class, [
                    'class' => Status::class,
                    'choice_label' => 'name'
                ])
            ->add('alternative_title')
            ->add('author')
            ->add('country')
            ->add('image')
        ;        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anime::class,
        ]);
    }
}
