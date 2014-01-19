# Extending UI and grids

**Topics**

- OroUIBundle (adding placeholders)
- OroGridBundle (extending grid, using listeners)
- adding widgets
- Twig extensions

**Changes**

```
src/Acme/Bundle/TaskBundle
    Controller
        TaskController (updated, added assignedTasksAction, added assigneeId to createAction)
    EventListener
        Datagrid
            AssignedTasksListener (created)
    Resources
        config
            datagrid.yml (updated, added assigned tasks grid)
            placeholders.yml (created)
            services.yml (updated, added new services)
        views
            Task
                widget
                    assignedTasks.html.twig (created)
                assignedTasks.html.twig (created)
    Twig
        TaskExtension (created)
```

## Adding tasks grid to user view page

1. Update Acme/Bundle/TaskBundle/Resources/config/datagrid.yml and add acme_task_assigned_tasks_grid

  ```
    acme_task_assigned_tasks_grid:
        extend: acme_task_grid
        source:
            query:
                where:
                    and:
                        - task.assignee = :assigneeId

  ```
  
2. Add Acme\Bundle\TaskBundle\EventListener\Datagrid\AssignedTasksListener and update services.yml

3. Add placeholder in Acme/Bundle/TaskBundle/Resources/config/placeholders.yml
  ```
  placeholders:
      oro_user_view_additional_data:
          items:
              acme_task_assigned_tasks:
                  order: 50

  items:
      acme_task_assigned_tasks:
          template: AcmeTaskBundle:Task:assignedTasks.html.twig
  ```

4. Add template Acme/Bundle/TaskBundle/Resources/views/Task/assignedTasks.html.twig with content of placeholder 

5. Add controller action Acme/Bundle/TaskBundle/Controller/TaskController::assignedTasks

6. Add template Acme/Bundle/TaskBundle/Resources/views/Task/widget/assignedTasks.html.twig with content of widget

7. Run command cache:clear

## Adding "Create task" button to user view page

1. Add Acme\Bundle\TaskBundle\Twig\TaskExtension and update services.yml

2. Update Acme/Bundle/TaskBundle/Resources/config/placeholders.yml with placeholder of create buttons

  ```
  placeholders:
    view_navButtons_after:
        items:
            acme_task_create_user_task_button:
                order: 50

   items:
      acme_task_create_user_task_button:
          template: AcmeTaskBundle:Task:createUserTaskButton.html.twig

  ```

3. Run command cache:clear

4. Add Acme/Bundle/TaskBundle/Resources/views/Task/createUserTaskButton.html.twig

5. Update action Acme/Bundle/TaskBundle/Controller/TaskController::createAction to use assigneeId

6. Go to user view page and check "Create task" button
