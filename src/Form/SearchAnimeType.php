<?php

namespace App\Form;

use App\Entity\Anime\Kind;
use App\Entity\Anime\Type;
use App\Entity\Anime\Status;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchAnimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'required'   => false
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
            ])
            ->add('kind', EntityType::class, [
                'class' => Kind::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('publishedMin', IntegerType::class, [
                'required'   => false
            ])
            ->add('publishedMax', IntegerType::class, [
                'required'   => false
            ])
            ->add('author', null, [
                'required'   => false
            ])
            ->add('country', null, [
                'required'   => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'get', // utilisation de la method get
            'csrf_protection' => false // ne pas afficher le token dans l'url
        ]);
    }

    public function getBlockPrefix()
    {
        // permet d'avoir une url plus friendly
        return '';
    }
}
