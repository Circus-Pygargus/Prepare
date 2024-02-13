<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangeUserIsActiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'hidden',
                ],
            ])
            ->add('wantedIsActive', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'true' => 'true',
                    'false' => 'false',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'hidden',
                ],
            ])
        ;
    }
}
