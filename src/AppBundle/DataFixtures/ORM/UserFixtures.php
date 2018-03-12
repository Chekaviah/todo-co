<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class UserFixtures.
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@website.net');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($passwordEncoder->encodePassword($admin, 'admin'));
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@website.net');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordEncoder->encodePassword($user, 'user'));
        $manager->persist($user);

        for ($i = 1; $i <= 20; ++$i) {
            $task = $this->getTask($i);

            if ($i > 10) {
                $user->addTask($task);
            }

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getTask($i)
    {
        $task = new Task();
        $task->setTitle('Task n°'.$i);
        $task->setContent($this->getRandomText());

        if (0 === $i % 3) {
            $task->setDone(true);
        }

        return $task;
    }

    private function getPhrases()
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText($maxLength = 255)
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);
        while (mb_strlen($text = implode('. ', $phrases).'.') > $maxLength) {
            array_pop($phrases);
        }

        return $text;
    }
}
