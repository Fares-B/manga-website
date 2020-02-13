<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Anime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voice')
            ->add('season')
            ->add('episode')
            ->add('format')
            // ->add('video')
            // ->add('createdAt')
            // ->add('slug')
            ->add('anime', EntityType::class, [
                'class' => Anime::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
