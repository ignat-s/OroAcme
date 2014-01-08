<?php

namespace OroAcme\Bundle\TodoListBundle\Tests\Unit\DependencyInjection;

use OroAcme\Bundle\TodoListBundle\DependencyInjection\OroAcmeTodoListExtension;

class OroWorkflowExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OroAcmeTodoListExtension
     */
    protected $extension;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->getMock();

        $this->extension = new OroAcmeTodoListExtension();
    }

    public function testLoad()
    {
        $this->container->expects($this->never())->method($this->anything());
        $this->extension->load(array(), $this->container);
    }
}
