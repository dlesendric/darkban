<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/3/2019
 * Time: 2:16 PM.
 */

namespace App\Tests\Controller;

use App\Tests\AppTestCase;
use App\Util\Board\BoardManagerInterface;

class TaskControllerTest extends AppTestCase
{
    public function testNewAction()
    {
        $user = $this->createUser();
        /**
         * @var BoardManagerInterface
         */
        $board_manager = self::$container->get('app.board_manager');
        $board = $board_manager->createBoard($user);
        $board->setName($this->generateRandomString());
        $list_manager = self::$container->get('app.lists_manager');

        $list = $list_manager->createLists($board);
        $list->setName($this->generateRandomString());
        $list_manager->save($board);
        $list_manager->save($list, true);

        $client = self::createClient();
        $token = $this->getTokenForUser($user);
        $data = [
            'list' => $list->getId(),
            'sortNo' => rand(1, 100),
            'name' => $this->generateRandomString(),
        ];
        $client->request(
            'POST',
            '/api/tasks/lists/'.$list->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
