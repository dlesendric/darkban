<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 1:18 AM.
 */

namespace App\Util\Lists;

use App\Entity\Board;
use App\Entity\Lists;
use App\Repository\ListsRepository;
use App\Util\ManagerInterface;

interface ListsManagerInterface extends ManagerInterface
{
    /**
     * @param Board $board
     *
     * @return array
     */
    public function getListsForBoard(Board $board);

    /**
     * @param Lists $list
     * @param Board $board
     *
     * @return void
     */
    public function addListToBoard(Lists $list, Board $board);

    /**
     * @return ListsRepository
     */
    public function getListsRepository();

    /**
     * @param Board $board
     * @param int   $sort
     *
     * @return Lists
     */
    public function createLists(Board $board, int $sort = 0);
}
