<?php

namespace App\Entity;

use App\Entity\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoardRepository")
 */
class Board
{
    use TimestampTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int|null
     * @ORM\Column(name="owner_id", type="integer", nullable=true)
     */
    private $ownerId;

    /**
     * @Assert\NotBlank()
     *
     * @var User
     * @Serializer\Groups({"owner"})
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $description;

    /**
     * @Serializer\Groups("lists")
     * @ORM\OneToMany(targetEntity="Lists", mappedBy="board")
     *
     * @var ArrayCollection
     */
    private $lists;

    /**
     * @Serializer\Groups("users")
     *
     * @var User[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="boards_users", joinColumns={@ORM\JoinColumn(name="board_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $users;

	/**
	 * Board constructor.
	 */
    public function __construct()
    {
        $this->lists = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

	/**
	 * @return int|null
	 */
    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return User|null
	 */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

	/**
	 * @param User $owner
	 *
	 * @return Board
	 */
    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

	/**
	 * @param string $name
	 *
	 * @return Board
	 */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param ArrayCollection $lists
     *
     * @return Board
     */
    public function setLists(ArrayCollection $lists)
    {
        $this->lists = $lists;

        return $this;
    }

    /**
     * @param Lists $lists
     *
     * @return $this
     */
    public function addList(Lists $lists)
    {
        $this->lists->add($lists);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Board
     */
    public function setDescription(?string $description): Board
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User[]|ArrayCollection $users
     *
     * @return Board
     */
    public function setUsers($users): Board
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    /**
     * @param int|null $ownerId
     *
     * @return Board
     */
    public function setOwnerId(?int $ownerId): Board
    {
        $this->ownerId = $ownerId;

        return $this;
    }
}
