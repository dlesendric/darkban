<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/26/2018
 * Time: 10:57 PM.
 */

namespace App\Util;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;

class ServiceManager implements ManagerInterface
{
    protected $em;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * ManagerInterface constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface    $serializer
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->em = $entityManager;
    }

    /**
     * @param      $obj
     * @param bool $flush
     *
     * @return mixed
     */
    public function save($obj, bool $flush = false)
    {
        $this->em->persist($obj);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @param        $obj
     * @param array  $groups
     * @param string $type
     *
     * @return mixed
     */
    public function serialize($obj, $type = 'array', $groups = ['Default'])
    {
        $context = SerializationContext::create()->setGroups($groups);
        switch ($type) {
            case 'array':
                return $this->serializer->toArray($obj, $context);
            default:
                return $this->serializer->serialize($obj, $type, $context);
        }
    }

    /**
     * @param      $obj
     * @param bool $flush
     *
     * @return $this
     */
    public function delete($obj, $flush = true)
    {
        $this->em->remove($obj);
        if ($flush) {
            $this->em->flush();
        }

        return $this;
    }
}
