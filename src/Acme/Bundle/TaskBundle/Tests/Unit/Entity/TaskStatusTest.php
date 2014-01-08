<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\Entity;

use Acme\Bundle\TaskBundle\Entity\TaskStatus;

class TaskStatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TaskStatus
     */
    protected $taskStatus;

    /**
     * @var string
     */
    protected $testName = 'test';

    protected function setUp()
    {
        $this->taskStatus = new TaskStatus($this->testName);
    }

    public function testName()
    {
        $this->assertEquals($this->testName, $this->taskStatus->getName());
    }

    public function testLabel()
    {
        $this->assertNull($this->taskStatus->getLabel());
        $label = 'test';
        $this->taskStatus->setLabel($label);
        $this->assertEquals($label, $this->taskStatus->getLabel());
    }
}
