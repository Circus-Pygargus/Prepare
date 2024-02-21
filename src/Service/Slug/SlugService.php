<?php

namespace App\Service\Slug;

use Doctrine\ORM\EntityManagerInterface;

class SlugService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Same baseSlug may have been already recorded in DB with a numbered suffix
     * Will return suffix number or null if none
     *
     * @param string $baseSlug
     * @param string $className
     * @param string $suffixSeparator
     * @return integer|null
     */
    public function findMaxSuffixValue(string $baseSlug, string $className, string $suffixSeparator = '_'): ?int
    {
        $slugLength = strlen($baseSlug);

        $classMetadata = $this->entityManager->getClassMetadata($className);
        $tableName = $classMetadata->getTableName();

        $conn = $this->entityManager->getConnection();

        $sql = 'SELECT MAX(RIGHT(t.slug, :slugLength))
            FROM '.$tableName.' t
            WHERE LEFT(t.slug, :slugLength) LIKE :baseSlug
                AND RIGHT(t.slug, 10) REGEXP \'d+\'';
        $resultSet = $conn->executeQuery($sql, [
            'baseSlug' => $baseSlug.$suffixSeparator,
            'slugLength' => $slugLength,
            'tableName' => $tableName
        ]);

        return $resultSet->fetchOne();
    }
}
