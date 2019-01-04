<?php

namespace App\Repository;

use App\Entity\Board;
use App\Entity\Lists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lists|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lists|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lists[]    findAll()
 * @method Lists[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lists::class);
    }

    public function findByBoard(Board $board)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->join('l.board', 'board')->addSelect('board');
        $qb->leftJoin('l.tasks', 'tasks')->addSelect('tasks');
        $qb->where('l.board = :board');
        $qb->addOrderBy('l.createdAt', 'asc');
        $qb->addOrderBy('tasks.sortNo', 'asc');
        $qb->setParameters([
            'board' => $board,
        ]);

        return $qb->getQuery()->getResult();
    }
}
