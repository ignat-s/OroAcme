## Install

### Clone git repository

```
git clone https://github.com/ignat-s/crm-application.git
```

### Install vendors

```
composer install --prefer-dist
```

### Run install command

```
app/console oro:install --env=dev --user-name=admin --user-email=admin@example.com --user-firstname=John --user-lastname=Doe --user-password=admin --sample-data=n --force
```

See detailed information https://github.com/ignat-s/crm-application/tree/master

### Add Acme as submodule

```
git submodule add https://github.com/ignat-s/Acme.git src/Acme
```

## Create virtual host

## Setup PHPStorm

1. Configure PHP (Settings > PHP)
2. Configure tests (Edit configuration > Defaults > PHPUnit)
3. Exclude app/cache

## Create new bundle

1. Add submodule git submodule add https://github.com/ignat-s/Acme.git src/Acme
2. Create bundle class Acme\Bundle\TaskBundle\AcmeTaskBundle
3. Create extension class Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension
4. Add Acme/Bundle/TaskBundle/Resources/config/services.yml
5. Add Acme/Bundle/TaskBundle/Resources/translations/messages.en.yml

## Register bundle

Create Acme/Bundle/TaskBundle/Resources/config/oro/bundles.yml

```
bundles:
    - Acme\Bundle\TaskBundle\AcmeTaskBundle
```

Update cache:

```
app/console cache:clear
```

## Create entities

1. Create Task entity (id, title, description, related contacts, status, assignee, owner, created at, updated at)
2. Create TaskStatus entity (name, label)
3. Create data fixture for statuses (open, closed, in progress)
4. Update database schema

```
app/console doctrine:schema:update --dump-sql
app/console doctrine:schema:update --force
```

5. Load fixtures of statuses

```
app/console doctrine:fixture:load --fixtures src/Acme/src/Acme/Bundle/TaskBundle/DataFixtures/ --append
```

## Tasks list

1. Add grid config Acme/Bundle/TaskBundle/Resources/config/datagrid.yml
2. Add controller class Acme\Bundle\TaskBundle\Controller\TaskController
3. Add Acme/Bundle/TaskBundle/Resources/config/oro/routing.yml
4. Add template Acme/Bundle/TaskBundle/Resources/views/Task/index.html.twig
5. Demonstrate tasks grid

## Create/update task form
1. Create form type Acme\Bundle\TaskBundle\Form\Type\TaskType (title, status, description, assignee, owner)
2. Create Acme/Bundle/TaskBundle/Resources/config/validation.yml
2. Create controller actions
3. Add create button to template Acme/Bundle/TaskBundle/Resources/views/Task/index.html.twig
4. Create template Acme/Bundle/TaskBundle/Resources/views/Task/update.html.twig
5. Demonstrate create/edit task
6. Add task view page

## Create view task page
1. Add controller action
2. Add Acme/Bundle/TaskBundle/Resources/views/Task/view.html.twig

## Add actions to grid
1. Add actions
2. Add properties

Notes:

1. Translation issues, for example OroUser:User:index.html.twig when using addButton
2. Translation of entities is not convenient and will not work in all languages:
   'Update'|trans ~ ' ' ~ 'oro.user.group.entity_label'|trans
   'New'|trans ~ ' ' ~ 'oro.user.group.entity_label'|trans
