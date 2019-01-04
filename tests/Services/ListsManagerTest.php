<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 2:23 AM.
 */

namespace App\Tests\Services;

use App\Tests\AppTestCase;
use App\Util\Lists\ListsManagerInterface;
use App\Util\ManagerInterface;

class ListsManagerTest extends AppTestCase
{
    public function testInterfaceImplementation()
    {
        $service = self::$container->get('app.lists_manager');
        $this->assertTrue($service instanceof ListsManagerInterface);
        $this->assertTrue($service instanceof ManagerInterface);
    }

    public function testAddListToBoard()
    {
        $user = $this->createUser();
        $boardManager = self::$container->get('app.board_manager');
        $listManager = self::$container->get('app.lists_manager');

        $board = $boardManager->createBoard($user);
        $list = $listManager->createLists($board);
        $this->assertEquals($board, $list->getBoard());
    }
}
