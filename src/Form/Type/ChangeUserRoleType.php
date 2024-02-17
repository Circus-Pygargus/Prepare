<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangeUserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'required' => true,
                'trim' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Tu dois entrer un pseudo.'
                    ])
                ],
                'attr' => [
                    'class' => 'hidden',
                ],
            ])
            ->add('wantedBiggestRole', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Utilisateur' => 'USER',
                    'Contributeur' => 'CONTRIBUTOR',
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
