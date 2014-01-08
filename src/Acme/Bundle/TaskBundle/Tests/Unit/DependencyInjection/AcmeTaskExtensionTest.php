<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\DependencyInjection;

use Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension;

class AcmeTaskExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AcmeTaskExtension
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

        $this->extension = new AcmeTaskExtension();
    }

    public function testLoad()
    {
        $this->container->expects($this->never())->method($this->anything());
        $this->extension->load(array(), $this->container);
    }
}
