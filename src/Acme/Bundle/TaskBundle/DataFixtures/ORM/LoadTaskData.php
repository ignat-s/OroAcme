<?php

namespace Acme\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\UserBundle\Entity\User;

use Acme\Bundle\TaskBundle\Entity\Task;
use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var array
     */
    protected $data = array(
        array(
            'statusName' => 'in_progress',
            'text' => 'Pass OroCRM training',
        ),
        array(
            'statusName' => 'open',
            'text' => 'Start develop with Oro',
        ),
        array(
            'statusName' => 'closed',
            'text' => 'Install OroCRM application',
        )
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $owner = $this->getOwner($manager);

        if ($owner) {
            foreach ($this->data as $data) {
                $status = $this->findStatus($manager, $data['statusName']);
                if ($status) {
                    $task = new Task();
                    $task->setText($data['text']);
                    $task->setStatus($status);
                    $task->setOwner($owner);
                    $manager->persist($task);
                }
            }

            $manager->flush();
        }
    }

    /**
     * @param string $text
     * @param TaskStatus $status
     * @param User $owner
     * @return Task
     */
    protected function createTask($text, TaskStatus $status, User $owner)
    {
        $result = new Task();
        $result->setText($text);
        $result->setStatus($status);
        $result->setOwner($owner);

        return $result;
    }

    /**
     * @param ObjectManager $manager
     * @param string $statusName
     * @return TaskStatus
     */
    protected function findStatus(ObjectManager $manager, $statusName)
    {
        return $manager->getRepository('AcmeTaskBundle:TaskStatus')->find($statusName);
    }

    /**
     * @param ObjectManager $manager
     * @return User
     */
    protected function getOwner(ObjectManager $manager)
    {
        return $manager->getRepository('OroUserBundle:User')->findOneBy(array('username' => 'admin'));
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 202;
    }
}
