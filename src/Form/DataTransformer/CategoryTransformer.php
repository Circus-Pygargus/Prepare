<?php

namespace App\Form\DataTransformer;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform(mixed $value): mixed
    {
        if (null === $value) {
            return '';
        }

        return $value->getId();
    }

    public function reverseTransform(mixed $value): mixed
    {
        if (!$value) {
            return null;
        }

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->find($value);

        if (null === $category) {
            throw new TransformationFailedException(sprintf('La catégorie avec l\'ID "%s" n\'a pas pu être trouvée.', $value));
        }

        return $category;
    }
}
