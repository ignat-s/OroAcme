<?php

namespace Acme\Bundle\TaskBundle\DataFixtures\ORM;

use Acme\Bundle\TaskBundle\Entity\Task;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTaskData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $assignee = $owner = $manager->getRepository('OroUserBundle:User')->findOneBy(array('username' => 'admin'));
        $status = $manager->getRepository('AcmeTaskBundle:TaskStatus')->findOneByName('open');

        if (!$owner || !$status) {
            return;
        }

        $task = new Task();
        $task->setTitle('New task');
        $task->setDescription('New description');
        $task->setStatus($status);
        $task->setOwner($owner);
        $task->setAssignee($assignee);

        $manager->persist($task);
        $manager->flush();
    }
}
