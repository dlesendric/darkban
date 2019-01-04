<?php

namespace App\Repository;

use App\Entity\Board;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Board|null find($id, $lockMode = null, $lockVersion = null)
 * @method Board|null findOneBy(array $criteria, array $orderBy = null)
 * @method Board[]    findAll()
 * @method Board[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Board::class);
    }

    /**
     * @param User $user
     * @param int  $page
     * @param int  $perPage
     *
     * @return Paginator
     */
    public function getBoardsForUser(User $user, int $page = 1, int $perPage = 10)
    {
        $dql = <<<DQL
SELECT b as item, 
(SELECT COUNT(l.id) FROM App\Entity\Lists l WHERE l.board = b.id) AS totalLists, 
(SELECT COUNT(t.id) FROM App\Entity\Lists lt LEFT JOIN lt.tasks t WHERE lt.board = b.id) AS totalTasks 
FROM App\Entity\Board b
LEFT JOIN b.users u
WHERE (b.owner =  :user OR u.id = :user)
ORDER BY b.createdAt DESC 
DQL;

        $qb = $this->_em->createQuery($dql);
        $qb->setParameters([
            'user' => $user->getId(),
        ]);
        $offset = ($page - 1) * $perPage;
        $qb->setFirstResult($offset);
        $qb->setMaxResults($perPage);
        $paginator = new Paginator($qb);

        return $paginator;
    }
}
