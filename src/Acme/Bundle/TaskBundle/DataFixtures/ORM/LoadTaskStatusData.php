<?php

namespace Acme\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class LoadTaskStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var array
     */
    protected $data = array(
        'closed' => 'Closed',
        'open' => 'Open',
        'in_progress' => 'In Progress'
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $statusName => $statusLabel) {
            if (!$this->isStatusExist($manager, $statusName)) {
                $entity = new TaskStatus($statusName);
                $entity->setLabel($statusLabel);
                $manager->persist($entity);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $statusName
     * @return bool
     */
    protected function isStatusExist(ObjectManager $manager, $statusName)
    {
        return null !== $manager->getRepository('AcmeTaskBundle:TaskStatus')->find($statusName);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 201;
    }
}
