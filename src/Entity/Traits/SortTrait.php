<?php

namespace App\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait SortTrait
{
    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $sortNo;

    /**
     * @return int|null
     */
    public function getSortNo(): ?int
    {
        return $this->sortNo;
    }

    /**
     * @param int $sortNo
     *
     * @return $this
     */
    public function setSortNo(int $sortNo)
    {
        $this->sortNo = $sortNo;

        return $this;
    }
}
