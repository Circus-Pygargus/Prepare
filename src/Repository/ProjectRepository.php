<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findAvailableForUser(User $user): array
    {
        return $this->createQueryBuilder('p')
        ->leftJoin('p.contributors', 'c')
        ->andWhere('c.id = :val')
        ->setParameter('val', $user)
        ->orderBy('p.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
    }

    /**
     * Same baseSlug may have been already recorded with a numbered suffix
     * Will return suffix number or null if none
     *
     * @param string $baseSlug
     * @param string $suffixSeparator
     * @return integer|null
     */
    public function findMaxSuffixValue(string $baseSlug, string $suffixSeparator = '_'): ?int
    {

        $slugLength = strlen($baseSlug);
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT MAX(RIGHT(p.slug, :slugLength))
            FROM project p
        WHERE LEFT(p.slug, :slugLength) LIKE :baseSlug
                AND RIGHT(p.slug, 10) REGEXP \'d+\'';
        $resultSet = $conn->executeQuery($sql, [
            'baseSlug' => $baseSlug.$suffixSeparator,
            'slugLength' => $slugLength,
        ]);

        return $resultSet->fetchOne();
    }
}
