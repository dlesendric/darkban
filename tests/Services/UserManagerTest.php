<?php

namespace App\Tests\Services;

use App\Tests\AppTestCase;
use App\Util\ManagerInterface;
use App\Util\User\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManagerTest extends AppTestCase
{
    public function testInterfaceImplementation()
    {
        $service = self::$container->get('app.user_manager');
        $this->assertTrue($service instanceof UserManagerInterface);
        $this->assertTrue($service instanceof ManagerInterface);
        $user = $service->createUser();
        $this->assertTrue($user instanceof UserInterface);
    }

    public function testHashedPasswordListener()
    {
        $service = self::$container->get('app.user_manager');
        $user = $service->createUser();
        $user->setEmail($this->generateRandomString(5).'-unit-test@test.com');
        $user->setActive(1);
        $user->setPlainPassword($this->generateRandomString());
        $plainPass = $user->getPlainPassword();
        $service->save($user, true);

        $refreshedUser = $service->getRepository()->find($user->getId());
        $this->assertNotNull($refreshedUser);
        $this->assertNotEquals($plainPass, $user->getPassword());
    }
}
