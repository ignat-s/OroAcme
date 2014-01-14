<?php

namespace Acme\Bundle\TaskBundle\Model;

use Doctrine\ORM\EntityManager;

use Acme\Bundle\TaskBundle\Entity\Repository\TaskRepository;
use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class Statistics
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $counts;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get statistics in format
     *
     * array(
     *     '<statusName>' => array(
     *         '<label>' => <statusLabel>,
     *         '<count>' => <tasksCount>,
     *     )
     * )
     *
     * @return array
     */
    public function getCounts()
    {
        if (null === $this->counts) {
            $this->counts = $this->calculateCounts();
        }
        return $this->counts;
    }

    /**
     * @return array
     */
    protected function calculateCounts()
    {
        $result = array();

        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->entityManager->getRepository('AcmeTaskBundle:Task');

        foreach ($this->getStatuses() as $status) {
            $result[$status->getName()] = array(
                'label' => $status->getLabel(),
                'count' => $taskRepository->getTasksCountByStatus($status)
            );
        }

        return $result;
    }

    /**
     * Get all tasks status
     *
     * @return TaskStatus[]
     */
    protected function getStatuses()
    {
        return $this->entityManager->getRepository('AcmeTaskBundle:TaskStatus')->findAll();
    }
}
