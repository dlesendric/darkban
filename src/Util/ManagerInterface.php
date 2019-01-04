<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/26/2018
 * Time: 9:37 PM.
 */

namespace App\Util;

interface ManagerInterface
{
    /**
     * @param      $obj
     * @param bool $flush
     *
     * @return mixed
     */
    public function save($obj, bool $flush = false);

    /**
     * @param        $obj
     * @param array  $groups
     * @param string $type
     *
     * @return mixed
     */
    public function serialize($obj, $type = 'array', $groups = ['Default']);

    /**
     * @param      $obj
     * @param bool $flush
     *
     * @return $this
     */
    public function delete($obj, $flush = true);
}
