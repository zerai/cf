<?php declare(strict_types=1);

/*
 * This file is part of the zerai/cf application
 *
 * @copyright (c) Zerai Teclai <teclaizerai@googlemail.com>.
 * @copyright (c) Francesca Bonadonna <francescabonadonna@googlemail.com>.
 *
 * This software consists of voluntary contributions made by many individuals
 * {@link https://github.com/zerai/cf/graphs/contributors developer} and is licensed under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iam\Adapter\Persistence;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Iam\Application\Model\BaseAccount;
use Iam\Application\Model\BaseAccountRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<BaseAccount>
 *
 * @method BaseAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method <array-key, Iam\Application\Model\BaseAccount> findAll()
 * @method <array-key, Iam\Application\Model\BaseAccount> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseAccountRepositoryDoctrine extends ServiceEntityRepository implements BaseAccountRepository, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseAccount::class);
    }

    public function save(BaseAccount $baseAccount): void
    {
        $this->add($baseAccount);
    }

    public function add(BaseAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BaseAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (! $user instanceof BaseAccount) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//    /**
//     * @return BaseAccount[] Returns an array of BaseAccount objects
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

//    public function findOneBySomeField($value): ?BaseAccount
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
