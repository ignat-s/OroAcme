<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\Entity;

use Oro\Bundle\UserBundle\Entity\User;

use Acme\Bundle\TaskBundle\Entity\Task;
use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Task
     */
    protected $task;

    protected function setUp()
    {
        $this->task = new Task();
    }

    public function testId()
    {
        $this->assertNull($this->task->getId());
        $id = 100;
        $this->task->setId($id);
        $this->assertEquals($id, $this->task->getId());
    }

    public function testText()
    {
        $this->assertNull($this->task->getText());
        $text = 'test';
        $this->task->setText($text);
        $this->assertEquals($text, $this->task->getText());
    }

    public function testStatus()
    {
        $this->assertNull($this->task->getStatus());
        $status = new TaskStatus('test');
        $this->task->setStatus($status);
        $this->assertEquals($status, $this->task->getStatus());
    }

    public function testOwner()
    {
        $this->assertNull($this->task->getOwner());
        $owner = new User();
        $this->task->setOwner($owner);
        $this->assertEquals($owner, $this->task->getOwner());
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->task->getCreatedAt());
        $createdAt = new \DateTime();
        $this->task->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->task->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->task->getUpdatedAt());
        $updatedAt = new \DateTime();
        $this->task->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $this->task->getUpdatedAt());
    }

    public function testPrePersist()
    {
        $this->task->prePersist();
        $this->assertInstanceOf('DateTime', $this->task->getCreatedAt());
    }

    public function testPreUpdate()
    {
        $this->task->preUpdate();
        $this->assertInstanceOf('DateTime', $this->task->getUpdatedAt());
    }
}
