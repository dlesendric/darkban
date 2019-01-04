<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 8:30 PM.
 */

namespace App\Tests\Services;

use App\Tests\AppTestCase;
use App\Util\Board\BoardManagerInterface;
use App\Util\ManagerInterface;

class BoardManagerTest extends AppTestCase
{
    public function testInterfaceImplementation()
    {
        $service = self::$container->get('app.board_manager');
        $this->assertTrue($service instanceof BoardManagerInterface);
        $this->assertTrue($service instanceof ManagerInterface);
    }
}
