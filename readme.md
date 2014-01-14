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

## Navigation menu
1. Add "Acme" and "Tasks" items into application menu
2. Add "Show tasks list" and "Create new task" items into shortcuts

## Navigation titles
1. Add oro_titles with titles for index, create, view, update
2. Run app/console oro:navigation:init
3. Add oro_title_set to Acme/Bundle/TaskBundle/Resources/views/Task/index.html.twig
4. Add oro_title_set to Acme/Bundle/TaskBundle/Resources/views/Task/view.html.twig
5. Add oro_title_set to Acme/Bundle/TaskBundle/Resources/views/Task/update.html.twig

## ACL
1. Add annotation to Task
@Config(
    defaultValues={
        "ownership"={
            "owner_type"="USER",
            "owner_field_name"="owner",
            "owner_column_name"="owner_id"
        },
        "security"={
            "type"="ACL"
        }
    }
)
2. Run command app/console oro:entity-config:update
3. Remove owner from form type as it's automatically added
4. Remove owner validation.yml as this constraint is embedded in field that automatically added
5. Add ACL annotations to TaskController
6. Go to roles and check Task entity
7. Change VIEW permission in Administrator role for Task from System to User and check how grid automatically protects users, change VIEW to System again
8. Change EDIT permission in Administrator role for Task from System to User and check permission error when you click on edit users
9. Add ACL annotations to datagrid.yml
10. Go to Task that is not with your owner and click edit to show permission error
11. Add ACL checks to templates

## Search
1. Add search.yml
2. Add Acme/Bundle/TaskBundle/Resources/views/Task/searchResult.html.twig
3. Demonstrate search

# Localization
1. Add formatting of owner and assignee name on the task view
2. Add formatting of created at/updated at the task search result
3. Show other twig function for formatting: oro_format_address, oro_format_datetime, oro_format_date, oro_format_time,
oro_format_name, oro_format_number, oro_format_currency, oro_format_decimal, oro_format_percent, oro_format_spellout,
oro_format_duration, oro_format_ordinal

# DataAudit
1. Add Loggable annotation to Task and "dataaudit"={"auditable"=true}
2. Add to Task fields
     * @Oro\Versioned
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
3. Run commands to update config
cache:clear
oro:entity-config:init
oro:entity-config:update
We have a bug here https://magecore.atlassian.net/browse/BAP-2846
4. Demonstrate how auditable works

# Rest API
1. Add JMS annotations to Task
2. Add Acme/Bundle/TaskBundle/Controller/Api/Rest/TaskController
3. Run cache:clear to warmup Acl annotations
4. Update Acme/Bundle/TaskBundle/Resources/config/oro/routing.yml with api
5. Check http://orocrm-training.local/app_dev.php/api/doc/ and demonstrate how it works
6. Add delete_link property and delete action to datagrid.yml
7. Add delete button to task view

Questions:

ACL:
1. Do we need to execute command php app/console init:acl (http://symfony.com/doc/current/cookbook/security/acl.html)
2. What do we support
"
 - **Class-Scope**: Allows to set permissions for all objects with the same type.
 - **Object-Scope**: Allows to set permissions for one specific object.
 - **Class-Field-Scope**: Allows to set permissions for all objects with the same type, but only to a specific field of the objects.
 - **Object-Field-Scope**: Allows to set permissions for a specific object, and only to a specific field of that object.
"
3. What is the difference created in BU and assigned to BU?
4. Business Unit ownersip type invalid image
Mike was create Account C and make Second BU as owner, Robert was create Account D and make Child BU as owner
5. All records in datagrids automatically protect with access levels?
6. https://github.com/laboro/platform/blob/master/src/Oro/Bundle/SecurityBundle/Resources/doc/acl-manager.md
entity: AcmeBundle:AcmeEntity
Entity:AcmeBundle:SomeEntity
7. After the setting new ACL permissions to an object, the changes must be saved. It can be done with flush function
8. https://github.com/laboro/platform/blob/master/src/Oro/Bundle/SecurityBundle/Resources/doc/implementation.md
"permissions"="VIEW;EDIT"
9. @Acl annotations only on controllers?
10.
bindings:
        - {  class: someClass, method: someMethod}
11. Is it required to set id and where it's used?7

     * @Acl(
     *      id="acme_task_view",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="VIEW"
     * )
12. After annotations are added do we need to execute any command?
13. Ownership is required in most cases?
14. Can ownership be changed by other bundle?
15. Flush is required after changing acl permission is it means that ACL works using Doctrine (in Symfony's original ACL they use PDO directly)
16. acl_resource in grid?

Search:
1. Why we need all_data in target fields?
2. How search works


Notes:

1. Translation issues, for example OroUser:User:index.html.twig when using addButton
2. Translation of entities is not convenient and will not work in all languages:
   'Update'|trans ~ ' ' ~ 'oro.user.grouAclManagerp.entity_label'|trans
   'New'|trans ~ ' ' ~ 'oro.user.group.entity_label'|trans

Search

1. If "search_template" option is missing error occurred
An exception has been thrown during the rendering of a template ("Trying to access not existing parameter: "template"") in OroSearchBundle:Search:searchResults.html.twig at line 49.
2. If "title_fields" is empty error displayed on search result page:
Catchable fatal error: Object of class Acme\Bundle\TaskBundle\Entity\Task could not be converted to string in /home/ignat/dev/orocrm-training/vendor/oro/platform/src/Oro/Bundle/SearchBundle/EventListener/PrepareResultItemListener.php on line 134
3. Search.yml files are not validated
