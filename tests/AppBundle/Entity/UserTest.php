<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserTest extends TestCase
{
    public function testAttributes()
    {
        $taskStub = $this->createMock(Task::class);
        $taskStub->method('getId')
            ->willReturn(0);

        $user = new User();
        $user->setUsername('username');
        $user->setPlainPassword('plainpassword');
        $user->setPassword('password');
        $user->setEmail('user@website.net');
        $user->setRoles(['ROLE_USER']);
        $user->addTask($taskStub);

        static::assertNull($user->getId());
        static::assertEquals('username', $user->getUsername());
        static::assertEquals('plainpassword', $user->getPlainPassword());
        static::assertEquals('password', $user->getPassword());
        static::assertEquals('user@website.net', $user->getEmail());
        static::assertEquals(['ROLE_USER'], $user->getRoles());
        static::assertEquals(0, $user->getTasks()->offsetGet(0)->getId());

        $user->removeTask($taskStub);

        static::assertEmpty($user->getTasks());
    }
}