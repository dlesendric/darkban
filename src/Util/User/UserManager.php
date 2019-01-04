<?php

namespace App\Util\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Util\ServiceManager;

class UserManager extends ServiceManager implements UserManagerInterface
{
    /**
     * @return User
     */
    public function createUser()
    {
        $user = new User();
        $user->setActive(1);

        return $user;
    }

    /**
     * @param User $user
     * @param bool $flush
     *
     * @return void
     */
    public function save($user, bool $flush = false)
    {
        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @return UserRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository(User::class);
    }
}
