<?php

namespace OroAcme\Bundle\TodoListBundle\Tests\Unit\Entity;

use OroAcme\Bundle\TodoListBundle\Entity\TodoStatus;

class TodoStatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TodoStatus
     */
    protected $todoStatus;

    /**
     * @var string
     */
    protected $testName = 'test';

    protected function setUp()
    {
        $this->todoStatus = new TodoStatus($this->testName);
    }

    public function testName()
    {
        $this->assertEquals($this->testName, $this->todoStatus->getName());
    }

    public function testLabel()
    {
        $this->assertNull($this->todoStatus->getLabel());
        $label = 'test';
        $this->todoStatus->setLabel($label);
        $this->assertEquals($label, $this->todoStatus->getLabel());
    }
}
