# Adding create/update/view actions and grid actions, using localization

**Topics**

- forms
- OroUIBundle (actions templates, Twig macroses)
- validation on backend and frontend
- OroLocalBundle (localication of names and datetimes)
- grid actions

**Changes**

```
src/Acme/Bundle/TaskBundle
    Controller
        TaskController (updated: added createAction, updateAction, viewAction)
    Form
        Type
            TaskType (created)
    Resources
        config
            validation.yml (created)
            services.yml (updated: added service for acme_task.form.type.task)
            datagrid.yml (updated: added protperties and actions)
        translations
            messages.en.yml (updated: added new messages)
        views
            Task
                index.html.twig (updated: added create button)
                update.html.twig (created)
    
```

## Add create/update/view actions

1. Create form type Acme\Bundle\TaskBundle\Form\Type\TaskType

2. Create Acme/Bundle/TaskBundle/Resources/config/validation.yml

3. Update Acme/Bundle/TaskBundle/Resources/config/services.yml and add service for new form type

4. Create controller actions

  * Acme\Bundle\TaskBundle\Controller\TaskController::createAction
  * Acme\Bundle\TaskBundle\Controller\TaskController::updateAction
  * Acme\Bundle\TaskBundle\Controller\TaskController::viewAction

5. Update Acme/Bundle/TaskBundle/Resources/translations/messages.en.yml

6. Add create button to template Acme/Bundle/TaskBundle/Resources/views/Task/index.html.twig

7. Create templates
  
  * Acme/Bundle/TaskBundle/Resources/views/Task/update.html.twig
  * Acme/Bundle/TaskBundle/Resources/views/Task/view.html.twig 

## Localization in twig templates

  * https://github.com/orocrm/platform/blob/master/src/Oro/Bundle/LocaleBundle/Resources/doc/index.md
  * http://orocrm-training.local/app_dev.php/acme/task#url=/app_dev.php/config/system/platform/localization

## Add datagrid actions

1. Update Acme/Bundle/TaskBundle/Resources/config/datagrid.yml

```
        properties:
            id: ~
            view_link:
                type: url
                route: acme_task_view
                params: [ id ]
            update_link:
                type: url
                route: acme_task_update
                params: [ id ]
```

```
        actions:
            view:
                type: navigate
                label: acme.task.datagrid.view_action.label
                icon: user
                link: view_link
                rowAction: true
            update:
                type: navigate
                label: acme.task.datagrid.update_action.label
                icon: edit
                link: update_link

```

2. Go to tasks grid and check actions in the most right column
