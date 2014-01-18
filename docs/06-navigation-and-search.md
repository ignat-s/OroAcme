# Navigation and search

**Topics**

- OroNavigationBundle (page titles, application menu, shortcuts)
- OroSearchBundle
- Installing assets

**Changes**

```
src/Acme/Bundle/TaskBundle
    Resources
        config
            navigation.yml (created)
            search.yml (created)
        views
            Task
                index.html.twig (updated)
                view.html.twig (updated)
                update.html.twig (updated)
                searchResult.html.twig (created)
        public
            images (created)
    
```

## Navigation menu

1. Add navigation menu to Acme/Bundle/TaskBundle/Resources/config/navigation.yml:

  ```
  oro_menu_config:
      items:
          acme_tab:
              label: Acme
              uri: '#'

          task_list:
              label: acme.task.entity_plural_label
              route: acme_task_index
              extras:
                  routes: ['acme_task_*']
                  description: List of tasks

          shortcut_task_create:
              label: Create new task
              route: acme_task_create
              extras:
                  description: Create new task
          shortcut_task_list:
              label: Show tasks list
              route: acme_task_index
              extras:
                  description: List of tasks
  
      tree:
          application_menu:
              children:
                  acme_tab:
                      children:
                          task_list: ~
          shortcuts:
              children:
                  shortcut_task_create: ~
                  shortcut_task_list: ~
  ```

2. Run command oro:navigation:init

3. Check new item in application menu and new shortcuts

## Navigation titles

1. Add navigation titles to Acme/Bundle/TaskBundle/Resources/config/navigation.yml:

  ```
  oro_titles:
      acme_task_index: ~
      acme_task_view: %%entity.title%%
      acme_task_create: Create %%entityName%%
      acme_task_update: %%entity.title%% - Edit
  ```

2. Update templates with titles by using oro_title_set Twig tag

3. Run command oro:navigation:init

4. Check new titles of tasks pages

## Search

1. Add Acme/Bundle/TaskBundle/Resources/config/search.yml

2. Add Acme/Bundle/TaskBundle/Resources/public/images with images and run command assets:install

2. Run command oro:search:reindex

3. Add Acme/Bundle/TaskBundle/Resources/views/Task/searchResult.html.twig

4. Check search

