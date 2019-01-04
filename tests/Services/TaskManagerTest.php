<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 2:06 PM.
 */

namespace App\Tests\Services;

use App\Repository\TaskRepository;
use App\Tests\AppTestCase;
use App\Util\ManagerInterface;
use App\Util\Task\TaskManagerInterface;

class TaskManagerTest extends AppTestCase
{
    public function testInterfaceImplementation()
    {
        $service = self::$container->get('app.task_manager');
        $this->assertTrue($service instanceof TaskManagerInterface);
        $this->assertTrue($service instanceof ManagerInterface);
        $this->assertTrue($service->getTasksRepository() instanceof TaskRepository);
    }

    public function testCreateTask()
    {
        /**
         * @var TaskManagerInterface
         */
        $service = self::$container->get('app.task_manager');

        $list_service = self::$container->get('app.lists_manager');

        $board_service = self::$container->get('app.board_manager');

        $user = $this->createUser();
        $board = $board_service->createBoard($user);
        $list = $list_service->createLists($board);
        $task = $service->createTask($list);

        $this->assertEquals($task->getList(), $list);
    }
}
