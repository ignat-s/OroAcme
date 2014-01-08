<?php

namespace OroAcme\Bundle\TodoListBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use OroAcme\Bundle\TodoListBundle\Entity\TodoStatus;

class LoadSourceData extends AbstractFixture
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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $sourceName => $sourceLabel) {
            $source = new TodoStatus($sourceName);
            $source->setLabel($sourceLabel);
            $manager->persist($source);
        }

        $manager->flush();
    }
}
