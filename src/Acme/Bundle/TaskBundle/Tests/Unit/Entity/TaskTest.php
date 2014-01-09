<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\Entity;

use Oro\Bundle\UserBundle\Entity\User;
use OroCRM\Bundle\ContactBundle\Entity\Contact;

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

    public function testTitle()
    {
        $this->assertNull($this->task->getTitle());
        $text = 'test';
        $this->task->setTitle($text);
        $this->assertEquals($text, $this->task->getTitle());
    }

    public function testDescription()
    {
        $this->assertNull($this->task->getDescription());
        $text = 'test';
        $this->task->setDescription($text);
        $this->assertEquals($text, $this->task->getDescription());
    }

    public function testRelatedContacts()
    {
        $this->assertInstanceOf('Doctrine\\Common\\Collections\\ArrayCollection', $this->task->getRelatedContacts());
        $this->assertTrue($this->task->getRelatedContacts()->isEmpty());

        $firstContact = new Contact();
        $firstContact->setId(100);

        $this->task->addRelatedContact($firstContact);

        $this->assertEquals(1, $this->task->getRelatedContacts()->count());
        $this->assertEquals($firstContact, $this->task->getRelatedContacts()->first());

        $secondContact = new Contact();
        $secondContact->setId(200);

        $this->task->addRelatedContact($secondContact);

        $this->assertEquals(2, $this->task->getRelatedContacts()->count());
        $this->assertEquals($secondContact, $this->task->getRelatedContacts()->last());

        $this->task->removeRelatedContact($firstContact);

        $this->assertEquals(1, $this->task->getRelatedContacts()->count());
        $this->assertEquals($secondContact, $this->task->getRelatedContacts()->first());
    }

    public function testStatus()
    {
        $this->assertNull($this->task->getStatus());
        $status = new TaskStatus('test');
        $this->task->setStatus($status);
        $this->assertEquals($status, $this->task->getStatus());
    }

    public function testAssignee()
    {
        $this->assertNull($this->task->getAssignee());
        $assignee = new User();
        $this->task->setAssignee($assignee);
        $this->assertEquals($assignee, $this->task->getAssignee());
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
