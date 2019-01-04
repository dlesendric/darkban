<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 9:40 PM.
 */

namespace App\Tests;

class SecurityTest extends AppTestCase
{
    public function testUserPassesSecurity()
    {
        $user = $this->createUser();
        $client = self::createClient();
        $data = [
            'username' => $user->getUsername(),
            'password' => self::TEST_PASS,
        ];

        $client->request(
            'POST',
            '/api/authentication',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $json = $client->getResponse()->getContent();
        $data = json_decode($json);
        $this->assertNotNull($data);
        $this->assertNotNull($data->token);
    }
}
