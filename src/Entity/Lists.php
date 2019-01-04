<?php

namespace App\Entity;

use App\Entity\Traits\SortTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * List is reserved word.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ListsRepository")
 */
class Lists
{
    use SortTrait;
    use TimestampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $dueDate;

    /**
     * @Serializer\Groups("board")
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="lists")
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     *
     * @var Board
     */
    private $board;

    /**
     * @Serializer\Groups("tasks")
     *
     * @var Task[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Task", mappedBy="list")
     */
    private $tasks;

	/**
	 * Lists constructor.
	 */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

	/**
	 * @return int|null
	 */
    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return string|null
	 */
    public function getName(): ?string
    {
        return $this->name;
    }

	/**
	 * @param string $name
	 *
	 * @return Lists
	 */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param Board $board
     *
     * @return Lists
     */
    public function setBoard(Board $board): Lists
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return Task[]|ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task[]|ArrayCollection $tasks
     *
     * @return Lists
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }
}
