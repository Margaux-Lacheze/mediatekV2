<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class FormationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('publishedAt', DateType::class, [
                    'label' => 'Date de publication',
                    'widget' => 'single_text',
                    'data' => isset($options['data']) &&
                    $options['data']->getPublishedAt() != null ? $options['data']->getPublishedAt() : new DateTime(),
                    'constraints' => [
                        new LessThanOrEqual([
                            'value' => 'today',
                            'message' => 'La date de publication ne peut pas être postérieure à la date d\'aujourd\'hui',
                                ]),
                    ],
                ])
                ->add('title', null, [
                    'label' => 'Titre'
                ])
                ->add('description')
                ->add('videoId', null, [
                    'label' => 'Id de la vidéo',
                    'required' => false,
                ])
                ->add('playlist', EntityType::class, [
                    'class' => Playlist::class,
                    'choice_label' => 'name',
                ])
                ->add('categories', EntityType::class, [
                    'class' => Categorie::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'label' => 'Catégories',
                    'required' => false
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Enregistrer'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}