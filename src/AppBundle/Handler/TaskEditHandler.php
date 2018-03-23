<?php

/**
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Handler;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class TaskEditHandler.
 */
class TaskEditHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TaskEditHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
