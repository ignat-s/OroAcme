<?php

namespace OroAcme\Bundle\TodoListBundle\Tests\Unit\Entity;

use Oro\Bundle\UserBundle\Entity\User;

use OroAcme\Bundle\TodoListBundle\Entity\TodoItem;
use OroAcme\Bundle\TodoListBundle\Entity\TodoStatus;

class TodoItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TodoItem
     */
    protected $todoItem;

    protected function setUp()
    {
        $this->todoItem = new TodoItem();
    }

    public function testId()
    {
        $this->assertNull($this->todoItem->getId());
        $id = 100;
        $this->todoItem->setId($id);
        $this->assertEquals($id, $this->todoItem->getId());
    }

    public function testText()
    {
        $this->assertNull($this->todoItem->getText());
        $text = 'test';
        $this->todoItem->setText($text);
        $this->assertEquals($text, $this->todoItem->getText());
    }

    public function testStatus()
    {
        $this->assertNull($this->todoItem->getStatus());
        $status = new TodoStatus('test');
        $this->todoItem->setStatus($status);
        $this->assertEquals($status, $this->todoItem->getStatus());
    }

    public function testOwner()
    {
        $this->assertNull($this->todoItem->getOwner());
        $owner = new User();
        $this->todoItem->setOwner($owner);
        $this->assertEquals($owner, $this->todoItem->getOwner());
    }

    public function testCreatedAt()
    {
        $this->assertNull($this->todoItem->getCreatedAt());
        $createdAt = new \DateTime();
        $this->todoItem->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->todoItem->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertNull($this->todoItem->getUpdatedAt());
        $updatedAt = new \DateTime();
        $this->todoItem->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $this->todoItem->getUpdatedAt());
    }

    public function testPrePersist()
    {
        $this->todoItem->prePersist();
        $this->assertInstanceOf('DateTime', $this->todoItem->getCreatedAt());
    }

    public function testPreUpdate()
    {
        $this->todoItem->preUpdate();
        $this->assertInstanceOf('DateTime', $this->todoItem->getUpdatedAt());
    }
}
