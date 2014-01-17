<?php

namespace Acme\Bundle\TaskBundle\Twig;

use Oro\Bundle\UserBundle\Entity\User;

class TaskExtension extends \Twig_Extension
{
    const NAME = 'acme_task';

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('acme_is_user_entity', array($this, 'isUserEntity')),
        );
    }

    /**
     * Check if entity is a user
     *
     * @param object $entity
     * @return bool
     */
    public function isUserEntity($entity)
    {
        return $entity instanceof User;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
