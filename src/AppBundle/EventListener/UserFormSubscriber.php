<?php

namespace AppBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserFormSubscriber
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if (null !== $user->getId()) {
            $form->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => false,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
            ]);
        }
    }
}
