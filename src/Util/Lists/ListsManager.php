<?php

namespace App\Util\Lists;

use App\Entity\Board;
use App\Entity\Lists;
use App\Repository\ListsRepository;
use App\Response\ApiListResponseBuilder;
use App\Util\ServiceManager;

class ListsManager extends ServiceManager implements ListsManagerInterface
{
    /**
     * @param Lists $list
     * @param Board $board
     */
    public function addListToBoard(Lists $list, Board $board)
    {
        $board->addList($list);
        $list->setBoard($board);
        $this->save($list);
    }

    /**
     * @param Board $board
     *
     * @return array
     */
    public function getListsForBoard(Board $board)
    {
        $result = $this->getListsRepository()->findByBoard($board);
        $builder = new ApiListResponseBuilder();
        $builder->setSerializer($this->serializer);
        $builder->createFromArray($result, ['Default', 'tasks']);

        return $builder->getResult();
    }

    /**
     * @return ListsRepository
     */
    public function getListsRepository()
    {
        return $this->em->getRepository(Lists::class);
    }

    /**
     * @param Board $board
     * @param int   $sort
     *
     * @return Lists
     */
    public function createLists(Board $board, int $sort = 0)
    {
        $list = new Lists();
        if ($sort > 0) {
            $list->setSortNo($sort);
        }
        $list->setBoard($board);
        $board->getLists()->add($list);

        return $list;
    }
}
