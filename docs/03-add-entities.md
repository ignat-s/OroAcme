# Add entities

**Topics**

- Doctrine
- Fixtures (ORM and Demo)

**Changes**

```
src/Acme/Bundle/TaskBundle
    DataFixtures
        Demo
            LoadTaskData (created)
        ORM
            LoadTaskStatusData (created)
    Entity
        Repository
            TaskRepository (created)
        Task (created)
        TaskStatus (created)
    Tests
        Unit
            Entity
                Task (created)
                TaskStatus (created)
```


## Create entities

1. Create class Acme\Bundle\TaskBundle\Entity\Task

2. Create class Acme\Bundle\TaskBundle\Entity\Repository\TaskRepository

3. Create class Acme\Bundle\TaskBundle\Entity\TaskStatus

4. Add tests and run them

## Update schema

```
app/console doctrine:schema:update --dump-sql
app/console doctrine:schema:update --force
```

## Add fixtures

1. Create class Acme\Bundle\TaskBundle\DataFixtures\ORM\LoadTaskStatusData

2. Create class Acme\Bundle\TaskBundle\DataFixtures\Demo\LoadTaskData

3. Load fixtures

```
app/console doctrine:fixture:load --fixtures src/Acme/src/Acme/Bundle/TaskBundle/DataFixtures/ --append
```

4. Check database tables for fixture data
