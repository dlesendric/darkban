<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 1:26 PM.
 */

namespace App\Util\Task;

use App\Entity\Lists;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Util\ServiceManager;

class TaskManager extends ServiceManager implements TaskManagerInterface
{
    /**
     * @return TaskRepository
     */
    public function getTasksRepository()
    {
        return $this->em->getRepository(Task::class);
    }

    /**
     * @param Lists $lists
     *
     * @return Task
     */
    public function createTask(Lists $lists)
    {
        $task = new Task();
        $task->setList($lists);
        $lists->getTasks()->add($task);

        return $task;
    }
}
