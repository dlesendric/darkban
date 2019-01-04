<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 11:12 PM.
 */

namespace App\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampTrait
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

	/**
	 * @return \DateTimeInterface|null
	 */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

	/**
	 * @param \DateTimeInterface $createdAt
	 *
	 * @return TimestampTrait
	 */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

	/**
	 * @return \DateTimeInterface|null
	 */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

	/**
	 * @param \DateTimeInterface $updatedAt
	 *
	 * @return TimestampTrait
	 */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
