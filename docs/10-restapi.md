# REST API

**Topics**

- how to add rest API to your bundle
- how to use JMSSerializer annotations
- how to use FOSRestBundle
- using ACL helper from OroSecurityBundle to secure ORM queries
- using X-CSRF-Header and X-WSSE
- adding delete action to grid
- functional tests

**Changes**

```
src/Acme/Bundle/TaskBundle
    Controller
        Api
            Rest
                TaskController (created)
    Form
        Type
            TaskApiType (created)
    Entity
        Task
    Resources
        config
            oro
                routing.yml (updated, added API controller)
            services.yml (updated, added api form service)
            datagrid.yml (updated, added delete link property and action)
        views
            Task
                view.html.twig (updated, added delete button)
    Tests
        Functional
            Controller
                Api
                    Rest
                        DataFixtutes (created)
                        TaskControllerTest (created)
                TaskControllerTest (created)
```


## Adding REST API

1. Add JMS annotations to Task

2. Add Acme/Bundle/TaskBundle/Form/Type/TaskApiType and service

3. Add Acme/Bundle/TaskBundle/Controller/Api/Rest/TaskController

4. Update Acme/Bundle/TaskBundle/Resources/config/oro/routing.yml with api controller

5. Run command cache:clear

6. Check http://orocrm-training.local/app_dev.php/api/doc/ (use header X-CSRF-Header: 1)

## Using WSSE

1. Go to any user view page and click "Generate key"

2. Run command oro:wsse:generate-header with user login

3. Use generated header in requests to API http://orocrm-training.local/app_dev.php/api/doc/

## Adding delete action to grid

1. Add delete_link property and delete action to datagrid.yml

2. Check delete action in Tasks grid

3. Add delete button to task Acme/Bundle/TaskBundle/Resources/views/Task/view.html.twig

4. Check delete button on Task view page






