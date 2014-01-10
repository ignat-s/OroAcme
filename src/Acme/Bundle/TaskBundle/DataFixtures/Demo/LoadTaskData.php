<?php

namespace Acme\Bundle\TaskBundle\DataFixtures\Demo;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

use Acme\Bundle\TaskBundle\Entity\Task;

/**
 * Loads fixtures tasks with random data.
 */
class LoadTaskData extends AbstractFixture implements OrderedFixtureInterface
{
    const FIXTURES_COUNT = 20;

    /**
     * @var array
     */
    static protected $fixtureTitles = array(
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit',
        'Aenean commodo ligula eget dolor',
        'Aenean massa',
        'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus',
        'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem',
        'Nulla consequat massa quis enim',
        'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu',
        'In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo',
        'Nullam dictum felis eu pede mollis pretium',
        'Integer tincidunt',
        'Cras dapibus',
        'Vivamus elementum semper nisi',
        'Aenean vulputate eleifend tellus',
        'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim',
        'Aliquam lorem ante, dapibus in, viverra quis, feugiat',
        'Aenean imperdiet. Etiam ultricies nisi vel',
        'Praesent adipiscing',
        'Integer ante arcu',
        'Curabitur ligula sapien',
        'Donec posuere vulputate'
    );

    /**
     * @var array
     */
    static protected $fixtureDescriptions = array(
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.',
        'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
        'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.',
        'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet.',
        'Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi..',
        'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra,',
        'Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel.',
        'Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus.',
        'Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed.',
        'Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.',
        'Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus.',
        'Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales.',
        'Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus.',
        'Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus.',
        'Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.',
        'Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing.',
        'Vestibulum volutpat pretium libero. Cras id dui. Aenean ut eros et nisl sagittis vestibulum.',
        'Sed lectus. Donec mollis hendrerit risus. Phasellus nec sem in justo pellentesque facilisis. Etiam imperdiet.',
        'Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Curabitur ligula sapien, tincidunt non.',
        'Praesent congue erat at massa. Sed cursus turpis vitae tortor. Donec posuere vulputate arcu.',
    );

    /**
     * @var array
     */
    protected $entitiesCount;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::FIXTURES_COUNT; ++$i) {
            $owner = $this->getRandomEntity('OroUserBundle:User', $manager);
            $assignee = $this->getRandomEntity('OroUserBundle:User', $manager);
            $status = $this->getRandomEntity('AcmeTaskBundle:TaskStatus', $manager);

            if (!$owner || !$status) {
                // If we don't have users and task statuses we cannot load fixture tasks
                break;
            }

            if ($manager->getRepository('AcmeTaskBundle:Task')->findOneByTitle(self::$fixtureTitles[$i])) {
                // Task with this title is already exist
                continue;
            }

            $task = new Task();
            $task->setTitle(self::$fixtureTitles[$i]);
            $task->setDescription(self::$fixtureDescriptions[$i]);
            $task->setStatus($status);
            $task->setOwner($owner);
            $task->setAssignee($assignee);

            $contactsCount = rand(0, 4);
            while ($contactsCount--) {
                $contact = $this->getRandomEntity('OroCRMContactBundle:Contact', $manager);
                if ($contact) {
                    $task->addRelatedContact($contact);
                } else {
                    break;
                }
            }

            $manager->persist($task);
        }

        $manager->flush();
    }

    /**
     * @param string $entityName
     * @param EntityManager $manager
     * @return object|null
     */
    protected function getRandomEntity($entityName, EntityManager $manager)
    {
        $count = $this->getEntityCount($entityName, $manager);

        if ($count) {
            return $manager->createQueryBuilder()
                ->select('e')
                ->from($entityName, 'e')
                ->setFirstResult(rand(0, $count - 1))
                ->setMaxResults(1)
                ->orderBy('e.' . $manager->getClassMetadata($entityName)->getSingleIdentifierFieldName())
                ->getQuery()
                ->getSingleResult();
        }

        return null;
    }

    /**
     * @param string $entityName
     * @param EntityManager $manager
     * @return int
     */
    protected function getEntityCount($entityName, EntityManager $manager)
    {
        if (!isset($this->entitiesCount[$entityName])) {
            $this->entitiesCount[$entityName] = (int)$manager->createQueryBuilder()
                ->select('COUNT(e)')
                ->from($entityName, 'e')
                ->getQuery()
                ->getSingleScalarResult();
        }

        return $this->entitiesCount[$entityName];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1000;
    }
}
