<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 1/2/2019
 * Time: 5:52 PM.
 */

namespace App\Response;

use App\Entity\Board;
use App\Entity\Lists;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class ApiListResponseBuilder
{
    private $items = [];

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $perPage;
    /**
     * @var \JMS\Serializer\Serializer
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     *
     * @return $this
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param int $perPage
     *
     * @return $this
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param Paginator $paginator
     * @param array     $groups
     *
     * @return $this
     */
    public function createFromPaginator(Paginator $paginator, $groups = ['Default'])
    {
        $this->reset();
        foreach ($paginator->getIterator() as $item) {
            $tmp = $this->serializer->toArray($item['item'], SerializationContext::create()->setGroups($groups));
            if ($item['item'] instanceof Board) {
                if (isset($item['totalLists'])) {
                    $tmp['totalLists'] = (int) $item['totalLists'];
                }
                if (isset($item['totalTasks'])) {
                    $tmp['totalTasks'] = (int) $item['totalTasks'];
                }
            }
            if ($item['item'] instanceof Lists) {
                if (isset($item['totalTasks'])) {
                    $tmp['totalTasks'] = (int) $item['totalTasks'];
                }
            }
            $this->items[] = $tmp;
        }
        $this->count = $paginator->count();

        return $this;
    }

    /**
     * @param       $data
     * @param array $groups
     *
     * @return $this
     */
    public function createFromArray($data, $groups = ['Default'])
    {
        $this->reset();
        foreach ($data as $item) {
            $tmp = $this->serializer->toArray($item, SerializationContext::create()->setGroups($groups));
            $this->items[] = $tmp;
        }
        $this->count = count($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        $result = [
            'items' => $this->items,
        ];
        if ($this->count) {
            $result['count'] = $this->count;
        }
        if ($this->perPage) {
            $result['perPage'] = $this->perPage;
        }
        if ($this->page) {
            $result['page'] = $this->page;
        }

        return $result;
    }

	/**
	 * Resets all fields in case this is shared service
	 */
    private function reset()
    {
        $this->items = []; //reset in case of duplicate call
        $this->count = null;
        $this->perPage = null;
        $this->page = null;
    }
}
