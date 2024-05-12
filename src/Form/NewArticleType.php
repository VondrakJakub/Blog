<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewArticleType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array(
                    'class' => 'mt-1 block w-full rounded-md border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 py-3 px-4 mb-4',
                    'placeholder' => 'Title'
                ),
                'label' => false
            ])
            ->add('content', TextareaType::class, [
                'attr' => array(
                    'class' => 'mt-1 block w-full h-80 rounded-md border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 py-3 px-4 mb-4',
                    'placeholder' => 'Content'
                ),
                'label' => false
            ])

            ->add('author', HiddenType::class, [
                'data' => $this->security->getUser()->getId(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
