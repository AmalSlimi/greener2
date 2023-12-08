<?php

namespace App\Repository;

use App\Entity\User1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User1>
* @implements PasswordUpgraderInterface<User1>
 *
 * @method User1|null find($id, $lockMode = null, $lockVersion = null)
 * @method User1|null findOneBy(array $criteria, array $orderBy = null)
 * @method User1[]    findAll()
 * @method User1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class User1Repository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User1::class);
    }

    /**
     * Used to upgrade (rehash) the user1's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user1, string $newHashedPassword): void
    {
        if (!$user1 instanceof User1) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user1->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user1);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return User1[] Returns an array of User1 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User1
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
