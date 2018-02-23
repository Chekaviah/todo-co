<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class TaskTest extends TestCase
{
    public function testAttributes()
    {
        $now = new \DateTime('NOW');

        $userStub = $this->createMock(User::class);
        $userStub->method('getId')
            ->willReturn(0);

        $task = new Task();
        $task->setTitle('Task');
        $task->setContent('Task content');
        $task->setCreated($now);
        $task->setDone(true);
        $task->setUser($userStub);

        static::assertNull($task->getId());
        static::assertEquals('Task', $task->getTitle());
        static::assertEquals('Task content', $task->getContent());
        static::assertEquals($now, $task->getCreated());
        static::assertEquals(true, $task->isDone());
        static::assertEquals(0, $task->getUser()->getId());
    }
}