# ACL

**Topics**

- OroSecurityBundle (annotations, protecting ORM queries and grids)
- OroEntityConfigBundle

**Changes**

```
src/Acme/Bundle/TaskBundle
    Controller
        TaskController (updated, added ACL annotations)
    Entity
        Task (updated, added ACL annotations)
    Resources
        config
            datagrid.yml (updated, added ACL configuration)
        views
            Task
                create.html.twig (updated, added security checks)
                update.html.twig (updated, added security checks)
                view.html.twig (updated, added security checks)
                searchResult.html.twig (updated, added security checks)
    
    
```

## Adding ACL annotations

1. Add annotation to Acme\Bundle\TaskBundle\Entity\Task:

  ```
    use Oro\Bundle\EntityConfigBundle\Metadata\Annotation as OroEntityConfig;

    /**    
     * @OroEntityConfig\Config(
     *  defaultValues={
     *      "ownership"={
     *          "owner_type"="USER",
     *          "owner_field_name"="owner",
     *          "owner_column_name"="owner_id"
     *      },
     *      "security"={
     *          "type"="ACL"
     *      }
     *  }
     */
    
  ```

2. Run command oro:entity-config:update

3. Update Acme\Bundle\TaskBundle\Controller\TaskController

  Add ACL annotations:

  ```
    /**
     * @Acl(
     *      id="acme_task_index",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="VIEW"
     * )
     */
  ```
  
  Remove code to handle owner from createAction method
  
4. Run command cache:clear  
  
5. Ensure that at least one task is owned by your user

6. Go to System -> User management -> Roles, select Administrator and check Task

7. Change VIEW permission for Task from "System" to "User" and check how Tasks grid automatically protects users, change VIEW to "System" again

8. Change EDIT permission in Administrator role for Task from "System" to "User" and check permission error when you click on edit users

9. Change CREATE permission in Administrator role for Task from "System" to "User" and check how you can create Tasks only with your user as owner

10. Change ASSIGN permission in Administrator role for Task from "System" to "User" and check how you can change Task owner only to your user

## Adding security to datagrid.yml 

1. Update Add ACL configuration to datagrid.yml

2. Change EDIT permission in Administrator role for Task to "None" and check how edit actions are not showing in grid

## Add security checks to templates

1. Add ACL checks to templates

2. Change ACL permissions and check UI on tasks pages for elements that are protected now


