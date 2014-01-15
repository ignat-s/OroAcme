<?php

namespace Acme\Bundle\TaskBundle\Tests\Unit\DependencyInjection;

use Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

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

    /**
     * @dataProvider loadParameterDataProvider
     */
    public function testLoadParameters($parameter)
    {
        $this->extension->load(array(), $this->container);
        $this->assertTrue($this->container->hasParameter($parameter));
    }

    public function loadParameterDataProvider()
    {
        return array(
            'acme_task.entity.class' => array('acme_task.entity.class'),
            'acme_task.form.type.task.class' => array('acme_task.form.type.task.class'),
            'acme_task.form.type.task_api.class' => array('acme_task.form.type.task_api.class'),
            'acme_task.statistics.class' => array('acme_task.statistics.class'),
        );
    }

    /**
     * @dataProvider loadServiceDataProvider
     */
    public function testLoadServices($service, $class, array $arguments, array $tags)
    {
        $this->extension->load(array(), $this->container);
        $definition = $this->container->getDefinition($service);

        $this->assertEquals($class, $definition->getClass());
        $this->assertTrue($this->container->hasParameter(trim($class, '%')));

        $this->assertEquals($arguments, $definition->getArguments());
        $this->assertEquals($tags, $definition->getTags());
    }

    public function loadServiceDataProvider()
    {
        return array(
            'acme_task.form.type.task' => array(
                'service' => 'acme_task.form.type.task',
                'class' => '%acme_task.form.type.task.class%',
                'arguments' => array('%acme_task.entity.class%'),
                'tags' => array(
                    'form.type' => array(
                        array('alias' => 'acme_task')
                    )
                )
            ),
            'acme_task.form.type.task_api' => array(
                'service' => 'acme_task.form.type.task_api',
                'class' => '%acme_task.form.type.task_api.class%',
                'arguments' => array(),
                'tags' => array(
                    'form.type' => array(
                        array('alias' => 'acme_task_api')
                    )
                )
            ),
            'acme_task.statistics' => array(
                'service' => 'acme_task.statistics',
                'class' => '%acme_task.statistics.class%',
                'arguments' => array(new Reference('doctrine.orm.entity_manager')),
                'tags' => array()
            )
        );
    }
}
