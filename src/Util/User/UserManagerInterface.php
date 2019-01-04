<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/26/2018
 * Time: 6:50 PM.
 */

namespace App\Util\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Util\ManagerInterface;

interface UserManagerInterface extends ManagerInterface
{
    /**
     * @return User
     */
    public function createUser();

    /**
     * @return UserRepository
     */
    public function getRepository();
}
