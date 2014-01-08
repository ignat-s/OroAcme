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

## Create new bundle

1. Add submodule git submodule add https://github.com/ignat-s/Acme.git src/Acme
2. Create bundle class Acme\Bundle\TaskBundle\AcmeTaskBundle
3. Create extension class Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension

## Register bundle

Create orocrm-training/src/Acme/src/Acme/Bundle/TaskBundle/Resources/config/oro/bundles.yml

```
bundles:
    - Acme\Bundle\TaskBundle\AcmeTaskBundle
```

Update cache:

```
app/console cache:clear
```

## Create entities

1. Create Task entity (id, text, status, owner, created at, updated at)
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

## Create a pages with list, create/edit forms
