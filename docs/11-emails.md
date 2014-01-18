# Emails notification

**Topics**

- configuring swiftmailer
- OroEmailBundle
- OroNotificationBundle
- using email configuration annotations
- using Twig functions in templates
- running Job Queue based on JMSQueueBundle

**Changes**

```
src/Acme/Bundle/TaskBundle
    DataFixtures
        data
            email
                create_task.html.twig (created)
        ORM
            LoadEmailTemplates (created)
    Resources
        config
            entity_output.yml (created)
```


## Configure email notifications

1. Configure swiftmailer in parameters.yml, for example:

   ```
    mailer_transport: smtp
    mailer_host: smtp.googlemail.com
    mailer_port: 465
    mailer_encryption: tls
    mailer_user: user@example.com
    mailer_password: password
   ```
   
2. Add Acme/Bundle/TaskBundle/Resources/config/entity_output.yml with data of Task entity

3. Add Acme/Bundle/TaskBundle/DataFixtures/data/email/create_task.html.twig

4. Add Acme\Bundle\TaskBundle\DataFixtures\ORM\LoadEmailTemplates

5. Load email templates 

  ```
  app/console doctrine:fixture:load --append --fixtures src/Acme/src/Acme/Bundle/TaskBundle/DataFixtures/ORM/
  ```
  
6. Go to System -> Emails -> Templates and check created template

7. Update fields in Task to support them in email templates

  ```
     * @ConfigField(
     *  defaultValues={
     *      "email"={"available_in_template"=true}
     *  }
     * )  
  ```
  
8. Run command oro:entity-config:update

9. Go to System -> Entites and check that fields are available in email templates

10. Go to System -> Notification -> Create notification rule

11. Go to System -> Job Queue and clock "Run daemon"

12. Create task and check your mail inbox
