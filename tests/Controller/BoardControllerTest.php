<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/2/2019
 * Time: 8:52 PM.
 */

namespace App\Tests\Controller;

use App\Tests\AppTestCase;
use App\Util\Board\BoardManagerInterface;

class BoardControllerTest extends AppTestCase
{
    public function testNewBoardAction()
    {
        $client = self::createClient();
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);

        $data = [
            'name' => $this->generateRandomString(),
            'description' => $this->generateRandomString(),
        ];
        $client->request(
            'POST',
            '/api/boards',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testListAction()
    {
        $client = self::createClient();
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);
        /**
         * @var BoardManagerInterface
         */
        $service = self::$container->get('app.board_manager');

        for ($i = 0; $i < 26; ++$i) {
            $board = $service->createBoard($user);
            $board->setName($this->generateRandomString());
            if (25 == $i) {
                $service->save($board, true);
            } else {
                $service->save($board);
            }
        }

        $client->request(
            'GET',
            '/api/boards',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            ''
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $json = $client->getResponse()->getContent();
        $data = json_decode($json);
        $this->assertEquals(25, count($data->items));
        $this->assertEquals($data->page, 1);
        $this->assertEquals($data->count, 26);
        $this->assertEquals($data->perPage, 25);

        $client->request(
            'GET',
            '/api/boards',
            [
                'page' => 2,
            ],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            ''
        );
        $json = $client->getResponse()->getContent();
        $data = json_decode($json);
        $this->assertEquals(1, count($data->items));
        $this->assertEquals($data->page, 2);
        $this->assertEquals($data->count, 26);
        $this->assertEquals($data->perPage, 25);
    }

    public function testUpdateAction()
    {
        $client = self::createClient();
        $user = $this->createUser();
        $token = $this->getTokenForUser($user);
        /**
         * @var BoardManagerInterface
         */
        $service = self::$container->get('app.board_manager');
        $board = $service->createBoard($user);
        $board->setName($this->generateRandomString());
        $service->save($board, true);

        $data = [
            'name' => $this->generateRandomString(),
            'description' => $this->generateRandomString(),
        ];
        $client->request(
            'PATCH',
            '/api/boards/'.$board->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );
        $this->assertTrue($client->getResponse()->isSuccessful());

        $refreshed = $service->getBoardRepository()->find($board->getId());
        $this->assertEquals($refreshed->getName(), $data['name']);
    }

    public function testPermission()
    {
        $client = self::createClient();
        $user = $this->createUser();

        /**
         * @var BoardManagerInterface
         */
        $service = self::$container->get('app.board_manager');
        $board = $service->createBoard($user);
        $board->setName($this->generateRandomString());
        $service->save($board, true);

        $secondUser = $this->createUser();
        $token = $this->getTokenForUser($secondUser);
        $data = [
            'name' => $this->generateRandomString(),
            'description' => $this->generateRandomString(),
        ];
        $client->request(
            'PATCH',
            '/api/boards/'.$board->getId(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            json_encode($data)
        );
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}
