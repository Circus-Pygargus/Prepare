<?php

namespace App\Form\Type;

use App\Entity\Project;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'trim' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'trim' => true,
            ])
            ->add('contributors', EntityType::class, [
                'label' => 'Participants',
                'required' => false,
                'class' => User::class,
                'query_builder' => function (UserRepository $ur): QueryBuilder {
                    return $ur->createQueryBuilder('u')
                        ->where('u.username NOT LIKE :name')
                        ->andWhere('u.isActive = true')
                        ->setParameter('name', $this->security->getUser()->getUserIdentifier());
                },
                'choice_label' => 'username',
                'expanded' => true,
                'multiple' => true,
                'empty_data' => [],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
