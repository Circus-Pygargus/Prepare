<?php

namespace App\Repository;

use App\Entity\IdeaType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IdeaType>
 *
 * @method IdeaType|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdeaType|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdeaType[]    findAll()
 * @method IdeaType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdeaType::class);
    }

//    /**
//     * @return IdeaType[] Returns an array of IdeaType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IdeaType
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
