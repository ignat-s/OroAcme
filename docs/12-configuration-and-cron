# Configuration and cron

**Topics**

- OroConfigBundle (adding bundle configuration settings)
- OroCronBundle (adding and running cron jobs)

**Changes**

```
src/Acme/Bundle/TaskBundle
    Command
        SendStatisticsCommand (created)
    DependencyInjection
        Configuration (updated, added default settings)
        AcmeTaskExtension (updated)
    Resources
        config
            system_configuration.yml (created)
            services.yml (updated, adding new service)
        translations
            messages.en.yml (updated)
        views
            Task
                statisticsMail.txt.twig (created)
    Model
        Statistics (created)
    Tests
        Unit
            DependencyInjection
                ConfigurationTest (created)
                AcmeTaskExtension (updated)
```

## Adding configuration of bundle

1. Add Acme/Bundle/TaskBundle/Resources/config/system_configuration.yml

2. Update Acme\Bundle\TaskBundle\DependencyInjection\Configuration

   ```
           SettingsBuilder::append(
            $rootNode,
            array(
                'send_statistics_cron_schedule' => array('value' => self::DEFAULT_SEND_STATISTICS_CRON_SCHEDULE),
                'send_statistics_email_to' => array('value' => null),
                'send_statistics_email_from' => array('value' => null),
                'send_statistics_enabled' => array('value' => false, 'type' => 'boolean'),
            )
        );
   ```
   
3. Update Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension

4. Go to System -> Configuration and check new settings

5. Change "Cron schedule" to "* * * * *" to demonstrate how email will be sent when cron job will be added

## Adding CRON job

1. Setup cron in OS
  
  ```
  sudo crontab -e 
  ```

  ```
  */1 * * * * /usr/bin/php /path_to_your_project_root/app/console --env=dev oro:cron >> /dev/null
  ```
  
2. Add Acme\Bundle\TaskBundle\Model\Statistics

3. Update services.yml with acme_task.statistics service

4. Add AcmeTaskBundle:Task:statisticsMail.txt.twig

5. Add Acme\Bundle\TaskBundle\Command\SendStatisticsCommand

6. Go to System -> Configuration enter settings for cron job

6. Go to System -> Job Queue and check job executions (ensure that JMSJobQueue daemon is running)

