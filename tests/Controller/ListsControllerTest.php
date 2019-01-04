<?php

namespace App\Tests\Controller;

use App\Tests\AppTestCase;
use App\Util\Board\BoardManagerInterface;

class ListsControllerTest extends AppTestCase
{
    public function testListsByBoardAction()
    {
        $user = $this->createUser();
        $boardManager = self::$container->get('app.board_manager');
        $listManager = self::$container->get('app.lists_manager');

        $board = $boardManager->createBoard($user);
        $board->setName($this->generateRandomString());
        $list = $listManager->createLists($board);
        $list->setName($this->generateRandomString());
        $listManager->save($board);
        $listManager->save($list, true);

        $this->assertNotNull($board->getId());
        $this->assertNotNull($list->getId());

        //test response
        $token = $this->getTokenForUser($user);
        $client = self::createClient();
        $client->request(
            'GET',
            '/api/lists/board/'.$board->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token]
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $json = $client->getResponse()->getContent();
        $data = json_decode($json);
        $this->assertNotEmpty($data->items);
        $this->assertEquals(1, $data->count);
    }

    public function testNewListAction()
    {
        $user = $this->createUser();
        /**
         * @var BoardManagerInterface
         */
        $boardManager = self::$container->get('app.board_manager');

        $board = $boardManager->createBoard($user);
        $board->setName($this->generateRandomString());
        $boardManager->save($board, true);
        $token = $this->getTokenForUser($user);
        $client = self::createClient();

        $data = [
            'name' => $this->generateRandomString(),
            'sortNo' => rand(1, 10),
        ];
        $client->request(
            'POST',
            '/api/lists/board/'.$board->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $refreshed = $boardManager->getBoardRepository()->find($board->getId());
        $this->assertNotEmpty($refreshed->getLists());
    }

    public function testUpdateListAction()
    {
        $user = $this->createUser();
        /**
         * @var BoardManagerInterface
         */
        $boardManager = self::$container->get('app.board_manager');
        $listManager = self::$container->get('app.lists_manager');
        $board = $boardManager->createBoard($user);
        $board->setName($this->generateRandomString());
        $boardManager->save($board);
        $list = $listManager->createLists($board);
        $list->setName($this->generateRandomString());
        $listManager->save($list, true);
        $token = $this->getTokenForUser($user);
        $client = self::createClient();

        $oldName = $list->getName();

        $data = [
            'name' => $this->generateRandomString(),
            'sortNo' => rand(1, 10),
        ];
        $client->request(
            'PATCH',
            '/api/lists/'.$list->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $refreshed = $listManager->getListsRepository()->find($list->getId());
        $this->assertNotEquals($oldName, $refreshed->getName());
    }
}
