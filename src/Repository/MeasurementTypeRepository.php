<?php

namespace App\Repository;

use App\Entity\MeasurementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MeasurementType>
 *
 * @method MeasurementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeasurementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeasurementType[]    findAll()
 * @method MeasurementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasurementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeasurementType::class);
    }

//    /**
//     * @return MeasurementType[] Returns an array of MeasurementType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MeasurementType
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
