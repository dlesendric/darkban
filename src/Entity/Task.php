<?php

namespace App\Entity;

use App\Entity\Traits\SortTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    use TimestampTrait;
    use SortTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $list_id;

    /**
     * @Gedmo\SortableGroup
     *
     * @var Lists
     * @ORM\ManyToOne(targetEntity="Lists", inversedBy="tasks")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id")
     */
    private $list;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getListId(): ?int
    {
        return $this->list_id;
    }

    public function setListId(?int $list_id): self
    {
        $this->list_id = $list_id;

        return $this;
    }

    /**
     * @return Lists
     */
    public function getList(): Lists
    {
        return $this->list;
    }

    /**
     * @param Lists $list
     *
     * @return Task
     */
    public function setList(Lists $list): Task
    {
        $this->list = $list;

        return $this;
    }
}
