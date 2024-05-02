<?php

namespace App\Repository;

use App\Entity\FamilyNode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FamilyNode>
 *
 * @method FamilyNode|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyNode|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyNode[]    findAll()
 * @method FamilyNode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyNodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyNode::class);
    }

    public function persist(FamilyNode $familyNode): FamilyNode
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($familyNode);
        $entityManager->flush();

        return $familyNode;
    }

//    /**
//     * @return FamilyNode[] Returns an array of FamilyNode objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FamilyNode
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
