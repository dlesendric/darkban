<?php

namespace App\Util\Board;

use App\Entity\Board;
use App\Entity\User;
use App\Repository\BoardRepository;
use App\Util\ManagerInterface;

interface BoardManagerInterface extends ManagerInterface
{
    /**
     * @param User $user
     *
     * @return Board
     */
    public function createBoard(User $user);

    /**
     * @return BoardRepository
     */
    public function getBoardRepository();

    /**
     * @param User $user
     * @param int  $page
     * @param int  $perPage
     *
     * @return array
     */
    public function getBoardsForUser(User $user, int $page = 1, int $perPage = 10);
}
