<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 11:11 PM.
 */

namespace App\Entity\Traits;

trait ActiveTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var bool
     */
    private $active = false;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
