<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function maxID($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $value);
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
        FROM App\Entity\User u
        JOIN u.roles r
        WHERE LOWER(r.role) = :role'
        );
        $query->setParameter('role', $role);

        $count = $query->getSingleScalarResult();

        return $count;
    }
    public function findLatestUsers(int $limit = 10): array
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    public function getUserByEmail(string $email): ?User
    {
        $query = $this->createQueryBuilder('user')
            ->where('user.mail = :email')
            ->setParameter('email', $email)
            ->getQuery();

        return $query->getOneOrNullResult();
    }





    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
