# Extended Entity

**Topics**

- OroEntityBundle (UI for entities)
- OroEntityExtendBundle (extend functionality)

**Changes**

```
src/Acme/Bundle/TaskBundle
    Resources
        config
            datagrid.yml (updated)
        views
            Task
                view.html.twig (updated)
                update.html.twig (updated)
```


## Making entity extended

1. Ensure Task entity extends ExtendTask class

  ```
  class Task extends ExtendTask
  ```
  
2. Go to System -> Entties and check "Is extend" column for Task
  
3. Add field to Task entity

4. Click "Update schema" button

4. Update Acme/Bundle/TaskBundle/Resources/config/datagrid.yml


  ```
  extended_entity_name: %acme_task.entity.class%
  ```

5. Check new field in grid

6. Update Acme/Bundle/TaskBundle/Resources/views/Task/view.html.twig

  ```
  {% import 'OroEntityConfigBundle::macros.html.twig' as entityConfig %}
  {{ entityConfig.renderDynamicFields(entity) }}
  ```
  
7. Check view page of Task

8. Update Acme/Bundle/TaskBundle/Resources/views/Task/update.html.twig

  ```
    {% if form.additional is defined and form.additional.children|length > 0 %}
        {% set additionalData = [] %}
        {% for value in form.additional %}
            {% set additionalData = additionalData|merge([form_row(value)]) %}
        {% endfor %}

        {% set dataBlocks = dataBlocks|merge([{
            'title': 'Additional'|trans,
            'subblocks': [{
                'title': '',
                'useSpan': false,
                'data' : additionalData
            }]
        }] ) %}
    {% endif %}
  ```
  
9. Check form page of Task
