# Getting Started

You can follow instructions in https://github.com/orocrm/crm-application/blob/master/README.md and install the
application.

You can just download a full archive with all vendors from here http://www.orocrm.com/download and skip next step.

**Clone crm-application repository**

We will clone to directory orocrm-training.

```
git clone https://github.com/orocrm/crm-application orocrm-training
```

**Use development repositories (optional)**

To use development repositories alter /composer.json or you can proceed with current release version:

```
    "require": {
        "oro/platform": "dev-master",
        "oro/crm": "dev-master",
        "escapestudios/wsse-authentication-bundle": "2.3.x-dev#ac3f700a88966e6483ff84d5de2b751d7622736d"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/laboro/platform.git"
        },
        {
            "type": "vcs",
            "url": "https://github.com/laboro/crm.git"
        }
    ],
```

**Create database**

Installing composer will ask you to enter some configuration parameters, like DB so make sure you have created one.
We will use DB "orocrm_training" and DB "orocrm_training_test" for functional testing.

**Install vendors**

```
composer install --prefer-dist
```

**Prepare a virtual host**

You need something like this using Apache:

```
    <VirtualHost *:80>
        DocumentRoot "/var/www/vhost/orocrm-training.local"
        ServerAdmin admin@localhost
        ServerName orocrm-training.local
        ServerAlias www.orocrm-training.local

        DirectoryIndex index.php index.html index.htm index.shtml

        <Directory "/var/www/vhost/orocrm-training.local">
            Options FollowSymLinks
            Options all
            AllowOverride All
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/orocrm-training.local-error.log
        CustomLog ${APACHE_LOG_DIR}/orocrm-training.local-access.log combined
    </VirtualHost>
```

Alter /etc/hosts file

```
127.0.0.1 orocrm-training.local
```

Restart your webserver

```
sudo /etc/init.d/apache2 restart
```

**Application installer**

You can install application using two options: from UI and from command line.

To install application from UI, open link in your favorite browser http://orocrm-training.local/ and follow the instructions.

To install from command line, use this command:

```
app/console oro:install
```

In any case choose to install sample data.


## Setup environment

**Basic setup in PHPStorm**

* Configure PHP (Settings -> PHP)
* Ensure xdebug is configured (Settings -> PHP -> Servers)
* Optionally install Symfony 2 plugin
* Enable PHPMD and PHPCS inspections
* Exclude folder app/cache to avoid indexing overload

**Configure PHPUnit**

* Configure tests (Edit configuration > Defaults > PHPUnit)
* Default configuration file - PROJECT_ROOT/app/phpunit.xml.dist
* Set custom working directory to your project root

**Update app/phpunit.xml.dist**

```
        <testsuite name="Project OroCRM Unit Tests">
            <directory suffix="Test.php">../vendor/oro/crm/src/OroCRM/Bundle/*Bundle/Tests/Unit</directory>
        </testsuite>
        <testsuite name="Project OroCRM Functional Tests">
            <directory suffix="Test.php">../vendor/oro/crm/src/OroCRM/Bundle/*Bundle/Tests/Functional</directory>
        </testsuite>
        <testsuite name="Project Oro Unit Tests">
            <directory suffix="Test.php">../vendor/oro/platform/src/Oro/Bundle/*Bundle/Tests/Unit</directory>
        </testsuite>
        <testsuite name="Project Oro Functional Tests">
            <directory suffix="Test.php">../vendor/oro/platform/src/Oro/Bundle/*Bundle/Tests/Functional</directory>
        </testsuite>
```

```
    <listeners>
        <listener class="TestListener" file="../vendor/oro/platform/src/Oro/Bundle/TestFrameworkBundle/Test/TestListener.php">
            <arguments>
                <string>app/logs</string>
            </arguments>
        </listener>
    </listeners>
```

**Run Oro unit tests from terminal**

```
phpunit -c app/ --testsuite "Project Oro Unit Tests"
phpunit -c app/ --testsuite "Project OroCRM Unit Tests"
```

**Run Oro functional tests**

Create parameters_test.yml, ensure that database is not the same as for main application, for example orocrm_training_test.

```
app/console oro:install --env=test --company-short-name=Acme --company-name=Acme --user-name=admin --user-email=admin@example.com --user-firstname=John --user-lastname=Doe --user-password=admin --sample-data=n
app/console doctrine:fixture:load --no-debug --append --no-interaction --env=test --fixtures vendor/oro/platform/src/Oro/Bundle/TestFrameworkBundle/Fixtures
```

Run functional tests:

```
phpunit -c app/ --testsuite "Project OroCRM Functional Tests" --stderr
phpunit -c app/ --testsuite "Project Oro Functional Tests" --stderr
```

