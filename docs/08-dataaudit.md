# Data Audit

**Topics**

- OroDataAuditBundle (annotations, audit)
- OroEntityConfigBundle (annotations)

**Changes**

```
src/Acme/Bundle/TaskBundle
    Entity
        Task (updated)
```

## Making entity auditable

1. Add annotation to Task entity

  ```
  use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
  use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

  use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;  
  
   * @Oro\Loggable
   * @Config(
   *  defaultValues={
   *      "dataaudit"={"auditable"=true}
   *  }
   * )
  ```

2. Add annotation to Task entity fields

  ```
     * @Oro\Versioned
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true}
     *  }
     * )
  ```
  
3. Run command oro:entity-config:update

4. Go to System -> Entities and check updates

5. Make any changes to any task and go to System -> Data Audit and check audit logs

