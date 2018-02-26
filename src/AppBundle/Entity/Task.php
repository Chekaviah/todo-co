<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message = "Vous devez saisir un titre.")
     * @Assert\Length(
     *     min = 3,
     *     max = 50,
     *     minMessage = "Le titre doit faire au minimum {{ limit }} caractères.",
     *     maxMessage = "Le titre doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type = "bool")
     */
    private $done;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->created = new Datetime();
        $this->done = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->done;
    }

    /**
     * @param bool $done
     */
    public function setDone($done)
    {
        $this->done = $done;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if(is_null($this->user)) {
            return $this->getAnonUser();
        }

        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    private function getAnonUser()
    {
        $user = new User();
        $user->setUsername('Anonyme');

        return $user;
    }
}
