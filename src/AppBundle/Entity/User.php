<?php

/**
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User.
 *
 * @ORM\Entity
 * @ORM\Table("user")
 * @UniqueEntity(
 *     fields = {"username"},
 *     message = "Ce nom est déjà utilisé."
 * )
 * @UniqueEntity(
 *     fields = {"email"},
 *     message = "Cet email est déjà utilisé."
 * )
 */
class User implements UserInterface
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
     * @var string
     *
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message = "Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     min = 3,
     *     max = 25,
     *     minMessage = "Le nom d'utilisateur doit faire au minimum {{ limit }} caractères.",
     *     maxMessage = "Le nom d'utilisateur doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $username;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message = "Vous devez saisir une adresse email.")
     * @Assert\Length(
     *     max = 60,
     *     maxMessage = "Le nom d'utilisateur doit faire au maximum {{ limit }} caractères."
     * )
     * @Assert\Email(message = "Le format de l'adresse n'est pas correct.")
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles = [];

    /**
     * @var Task[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", cascade={"persist", "refresh"}, mappedBy="user")
     */
    private $tasks;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;
        $task->setUser($this);
    }

    /**
     * @param Task $task
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * @return ArrayCollection|Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }
}
