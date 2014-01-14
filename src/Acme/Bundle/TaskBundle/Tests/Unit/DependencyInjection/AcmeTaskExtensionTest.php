<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension;

class AcmeTaskExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AcmeTaskExtension
     */
    protected $extension;

    /**
     * @var ContainerBuilder
     */
    protected $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new AcmeTaskExtension();
    }

    public function testLoad()
    {
        $this->extension->load(array(), $this->container);
        $this->assertTrue($this->container->hasParameter('acme_task.entity.class'));
    }
}
