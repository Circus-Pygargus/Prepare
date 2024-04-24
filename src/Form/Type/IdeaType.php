<?php

namespace App\Form\Type;

use App\Entity\Idea;
use App\Entity\IdeaType as EntityIdeaType;
use App\Entity\MeasurementType;
use App\Form\DataTransformer\CategoryTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class IdeaType extends AbstractType
{
    public function __construct(
        private CategoryTransformer $transformer,
        private Security $security,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Tu dois choisir un type d\'idée',
                    ])
                ],
                'class' => EntityIdeaType::class,
                'choice_label' => 'name',
                'empty_data' => '',
                'placeholder' => 'Choisis un type',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'trim' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Tu dois entrer un nom.'
                    ])
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'trim' => true,
            ])
            ->add('measurementType', EntityType::class, [
                'label' => 'Type de mesure',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Tu dois choisir un type de mesure'
                    ]),
                ],
                'class' => MeasurementType::class,
                'choice_label' => 'name',
                'empty_data' => '',
                'placeholder' => 'Choisis un type de mesure',
                'attr' => [
                    'row_id' => 'measurement-type',
                ],
                'choice_attr' => function($choice) {
                    return [
                        'data-idea-type' => $choice->getIdeaType()->getName(),
                    ];
                },
            ])
            ->add('quantity', TextType::class, [
                'label' => 'Quantité',
                'required' => false,
                'trim' => true,
                'help' => 'Ici on rempli la quantité nécéssaire,
on peut aussi écrire la quantité détenue ou proposée comparée à la quantité nécessaire, par exemple : 3 kg sur 4,
attention ! 3/4 kg sera compris comme 0.75.
Merci d\'écrire l\'unité de mesure si elle est différente du nom de l\'idée.', // Ne pas modifier l'indentation, elle est utilisée pour l'affichage
            ])
            ->add('needed', ChoiceType::class, [
                'label' => 'Nécessaire',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('proposed', ChoiceType::class, [
                'label' => 'Je peux fournir',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('owned', ChoiceType::class, [
                'label' => 'J\'ai',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('validated', ChoiceType::class, [
                'label' => 'Validé',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('category', HiddenType::class, [
                'required' => true,
            ])
        ;

        $builder->get('category')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}
