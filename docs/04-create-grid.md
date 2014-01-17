# Create grid

**Topics**

- OroDatagridBundle
- controllers
- routing and OroDistributionBundle
- Twig templates
- translations
- DIC

**Changes**

```
src/Acme/Bundle/TaskBundle
    Controller
        TaskController (created)
    DependencyInjection
        AcmeTaskExtension (updated)
    Resources
        config
            oro
                routing.yml (created)
            datagrid.yml (created)
            services.yml (created)
        translations
            messages.en.yml (created)
        views
            Task
                index.html.twig (created)
    Tests
        Unit
            DependencyInjection
                AcmeTaskExtensionTest (updated)
```


## Add grid

1. Add grid config Acme/Bundle/TaskBundle/Resources/config/datagrid.yml

2. Add translations src/Acme/src/Acme/Bundle/TaskBundle/Resources/translations/messages.en.yml

3. Add parameter of task class src/Acme/src/Acme/Bundle/TaskBundle/Resources/config/services.yml

4. Update Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension

- add $loader->load('services.yml');

4. Add controller class Acme\Bundle\TaskBundle\Controller\TaskController

5. Add Acme/Bundle/TaskBundle/Resources/config/oro/routing.yml

6. Add template Acme/Bundle/TaskBundle/Resources/views/Task/index.html.twig

7. Clear cache
```
app/console cache:clear
```

8. Go to http://orocrm-training.local/app_dev.php/acme/task
