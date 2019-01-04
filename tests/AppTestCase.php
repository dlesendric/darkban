<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/26/2018
 * Time: 8:00 PM.
 */

namespace App\Tests;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppTestCase extends WebTestCase
{
    const TEST_PASS = 'test1234';

    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
    }

    protected function tearDown()
    {
        $em = self::$container->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $purger->purge();

        parent::tearDown();
    }

    /**
     * @param int $length
     *
     * @return string
     */
    protected function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Create unit user.
     *
     * @return User
     */
    protected function createUser()
    {
        $service = self::$container->get('app.user_manager');
        $user = $service->createUser();
        $user->setPlainPassword(self::TEST_PASS);
        $user->setEmail($this->generateRandomString(5).'.unit-test@test.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $service->save($user, true);

        return $user;
    }

    /**
     * Create JWT token.
     *
     * @param User $user
     *
     * @return string
     */
    protected function getTokenForUser(User $user)
    {
        try {
            return self::$container->get('lexik_jwt_authentication.encoder')->encode(['email' => $user->getEmail()]);
        } catch (JWTEncodeFailureException $e) {
            return null;
        }
    }
}
