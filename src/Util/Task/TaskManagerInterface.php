<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 1:24 PM.
 */

namespace App\Util\Task;

use App\Entity\Lists;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Util\ManagerInterface;

interface TaskManagerInterface extends ManagerInterface
{
    /**
     * @return TaskRepository
     */
    public function getTasksRepository();

    /**
     * @param Lists $lists
     *
     * @return Task
     */
    public function createTask(Lists $lists);
}
