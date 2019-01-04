<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2018
 * Time: 6:25 PM.
 */

namespace App\Tests\Controller;

use App\Tests\AppTestCase;

class UserControllerTest extends AppTestCase
{
    public function testUserCreate()
    {
        $client = self::createClient();
        $data = [
            'firstName' => $this->generateRandomString(),
            'lastName' => $this->generateRandomString(),
            'plainPassword' => [
                'first' => 'test1234',
                'second' => 'test1234',
            ],
            'email' => 'test-'.$this->generateRandomString().'@test.com',
        ];
        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertTrue($client->getResponse()->isSuccessful());

        $service = self::$container->get('app.user_manager');

        $user = $service->getRepository()->findOneBy([
            'email' => $data['email'],
        ]);

        $this->assertNotNull($user);
    }

    public function testUserByEmailAction()
    {
        $user = $this->createUser();
        $client = self::createClient();
        $client->request(
            'POST',
            '/api/users/'.$user->getEmail(),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $json = $client->getResponse()->getContent();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $data = json_decode($json);
        $this->assertEquals($user->getEmail(), $data->email);
    }
}
