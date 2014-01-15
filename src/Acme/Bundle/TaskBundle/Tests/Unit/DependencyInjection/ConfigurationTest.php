<?php


namespace Acme\Bundle\TaskBundle\Tests\Unit\DependencyInjection;

use Acme\Bundle\TaskBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $builder = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $builder);
    }

    /**
     * @dataProvider processConfigurationDataProvider
     */
    public function testProcessConfiguration($configs, $expected)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $this->assertEquals($expected, $processor->processConfiguration($configuration, $configs));
    }

    public function processConfigurationDataProvider()
    {
        return array(
            'empty' => array(
                'configs' => array(array()),
                'expected' => array(
                    'settings' => array(
                        'resolved' => true,
                        'send_statistics_cron_schedule' => array(
                            'value' => Configuration::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE,
                            'scope' => 'app'
                        ),
                        'send_statistics_email_to' => array(
                            'value' => null,
                            'scope' => 'app'
                        ),
                        'send_statistics_email_from' => array(
                            'value' => null,
                            'scope' => 'app'
                        ),
                        'send_statistics_enabled' => array(
                            'value' => false,
                            'scope' => 'app'
                        )
                    )
                )
            ),
            'full' => array(
                'configs' => array(
                    array(
                        'settings' => array(
                            'send_statistics_cron_schedule' => array(
                                'value' => Configuration::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE
                            ),
                            'send_statistics_email_to' => array('value' => 'email@example.com'),
                            'send_statistics_email_from' => array('value' => 'email@example.com'),
                            'send_statistics_enabled' => array('value' => true),
                        )
                    )
                ),
                'expected' => array(
                    'settings' => array(
                        'send_statistics_cron_schedule' => array(
                            'value' => Configuration::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE,
                            'scope' => 'app'
                        ),
                        'send_statistics_email_to' => array(
                            'value' => 'email@example.com',
                            'scope' => 'app'
                        ),
                        'send_statistics_email_from' => array(
                            'value' => 'email@example.com',
                            'scope' => 'app'
                        ),
                        'send_statistics_enabled' => array(
                            'value' => true,
                            'scope' => 'app'
                        ),
                        'resolved' => true
                    )
                )
            ),
            'merge' => array(
                'configs' => array(
                    array(
                        'settings' => array(
                            'send_statistics_cron_schedule' => array(
                                'value' => Configuration::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE
                            ),
                            'send_statistics_email_to' => array('value' => 'email@example.com'),
                            'send_statistics_email_from' => array('value' => 'email@example.com'),
                            'send_statistics_enabled' => array('value' => true),
                        )
                    ),
                    array(
                        'settings' => array(
                            'send_statistics_cron_schedule' => array(
                                'value' => '*/5 * * * *'
                            ),
                            'send_statistics_email_to' => array('value' => 'email@example.com'),
                            'send_statistics_email_from' => array('value' => null),
                            'send_statistics_enabled' => array('value' => true),
                        )
                    )
                ),
                'expected' => array(
                    'settings' => array(
                        'send_statistics_cron_schedule' => array(
                            'value' => '*/5 * * * *',
                            'scope' => 'app'
                        ),
                        'send_statistics_email_to' => array(
                            'value' => 'email@example.com',
                            'scope' => 'app'
                        ),
                        'send_statistics_email_from' => array(
                            'value' => null,
                            'scope' => 'app'
                        ),
                        'send_statistics_enabled' => array(
                            'value' => true,
                            'scope' => 'app'
                        ),
                        'resolved' => true
                    )
                )
            )
        );
    }
}
