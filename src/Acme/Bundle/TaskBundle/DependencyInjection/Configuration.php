<?php

namespace Acme\Bundle\TaskBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;

class Configuration implements ConfigurationInterface
{
    const DEFAULT_SEND_STATISTICS_CRON_SCHEDULE = '* 08,17 * * *';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->root('acme_task');

        SettingsBuilder::append(
            $rootNode,
            array(
                'send_statistics_cron_schedule' => array('value' => self::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE),
                'send_statistics_email_to' => array('value' => null),
                'send_statistics_email_from' => array('value' => null),
                'send_statistics_enabled' => array('value' => false, 'type' => 'boolean'),
            )
        );

        return $treeBuilder;
    }
}
