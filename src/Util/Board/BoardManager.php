<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/26/2018
 * Time: 10:56 PM.
 */

namespace App\Util\Board;

use App\Entity\Board;
use App\Entity\User;
use App\Repository\BoardRepository;
use App\Response\ApiListResponseBuilder;
use App\Util\ServiceManager;

class BoardManager extends ServiceManager implements BoardManagerInterface
{
    /**
     * @return BoardRepository
     */
    public function getBoardRepository()
    {
        return $this->em->getRepository(Board::class);
    }

    /**
     * @param User $user
     * @param int  $page
     * @param int  $perPage
     *
     * @return array
     */
    public function getBoardsForUser(User $user, int $page = 1, int $perPage = 10)
    {
        if ($page < 1) {
            throw new \RuntimeException('Page must be at least 1');
        }
        $paginator = $this->getBoardRepository()->getBoardsForUser($user, $page, $perPage);
        $builder = new ApiListResponseBuilder();
        $builder->setSerializer($this->serializer);
        $builder->createFromPaginator($paginator);
        $builder->setPage($page);
        $builder->setPerPage($perPage);

        return $builder->getResult();
    }

    /**
     * @param User $user
     *
     * @return Board
     */
    public function createBoard(User $user)
    {
        $board = new Board();
        $board->setOwner($user);

        return $board;
    }
}
