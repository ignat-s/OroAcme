<?php

namespace Acme\Bundle\TaskBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class TaskRepository extends EntityRepository
{
    /**
     * @param TaskStatus $status
     * @return integer
     */
    public function getTasksCountByStatus(TaskStatus $status)
    {
        return $this->createQueryBuilder('task')
            ->select('COUNT(task)')
            ->where('task.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
