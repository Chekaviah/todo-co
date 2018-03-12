<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class TaskCreateHandler.
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class TaskCreateHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * TaskCreateHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param TokenStorage           $tokenStorage
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param FormInterface $form
     * @param Task          $task
     *
     * @return bool
     */
    public function handle(FormInterface $form, Task $task)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->tokenStorage->getToken()->getUser();
            $task->setUser($user);

            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
