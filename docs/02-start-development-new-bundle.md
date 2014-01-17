# Start development

**Topics**

- Fundamental
- Git submodule
- OroDistributionBundle and loading bundles
- Unit testing

**Changes**

```
src/Acme/Bundle/TaskBundle
    DependencyInjection
        AcmeTaskExtension (created)
    Resources
        config
            oro
                bundles.yml (created)
    Tests
        Unit
            DependencyInjection
                AcmeTaskExtensionTest (created)
            AcmeTaskBundleTest (created)
    AcmeTaskBundle (created)
```


## Prepare repository

First of all create a repository at https://github.com or use existing one.
Then add this repository as a submodule and place it in src directory:

```
git submodule add https://github.com/laboro/training src/Acme
git submodule init
git submodule update
```

If you are using PHPStorm go to Settings->Version Control and add this repository as Git root repository.

## Create a new bundle

1. Update composer.json autoloading:
```
    "autoload": {
        "psr-0": {
           "": "src/",
           "OroEmail\\": "app/emails",
           "Acme\\Bundle": "src/Acme/src"
         }
    },
```

2. Run composer update

3. Create bundle class Acme\Bundle\TaskBundle\AcmeTaskBundle.

4. Create class Acme\Bundle\TaskBundle\DependencyInjection\Configuration

5. Create class Acme\Bundle\TaskBundle\DependencyInjection\AcmeTaskExtension.

6. Add tests and run them

7. Register bundle by adding Acme/Bundle/TaskBundle/Resources/config/oro/bundles.yml

8. Check bundle is loaded using developer toolbar in UI
