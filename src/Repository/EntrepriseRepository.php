<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entreprise>
 *
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }
    public function countMen()
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) AS menCount')
            ->andWhere('LOWER(b.genre) = :gender')
            ->setParameter('gender', 'homme')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countWomen()
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) AS womenCount')
            ->andWhere('LOWER(b.genre) = :gender')
            ->setParameter('gender', 'femme')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function getRoleCount(string $role): int
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT COUNT(u) AS count
            FROM App\Entity\Entreprise u
            JOIN u.roles r
            WHERE LOWER(r.role) = :role'
        );
        $query->setParameter('role', $role);

        $count = $query->getSingleScalarResult();

        return $count;
    }
    public function getUserByEmail(string $email): ?Entreprise
    {
        $query = $this->createQueryBuilder('entreprise')
            ->where('entreprise.mail = :email')
            ->setParameter('email', $email)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    //    /**
    //     * @return Entreprise[] Returns an array of Entreprise objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
