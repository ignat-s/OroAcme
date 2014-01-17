<?php

namespace Acme\Bundle\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    /**
     * @var string
     */
    protected $taskClass;

    /**
     * @param string $taskClass
     */
    public function __construct($taskClass = 'Acme\Bundle\TaskBundle\Entity\Task')
    {
        $this->taskClass = $taskClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'text',
                array(
                    'label' => 'acme.task.title.label',
                    'required' => true,
                )
            )
            ->add(
                'status',
                'entity',
                array(
                    'label' => 'acme.task.status.label',
                    'class' => 'AcmeTaskBundle:TaskStatus',
                    'property' => 'label',
                    'required' => true
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'label' => 'acme.task.description.label',
                    'required' => false,
                )
            )->add(
                'assignee',
                'oro_user_select',
                array('required' => false, 'label' => 'acme.task.assignee.label')
            )->add(
                'relatedContact',
                'orocrm_contact_select',
                array(
                    'required' => false,
                    'label' => 'acme.task.relatedContact.label'
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->taskClass
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'acme_task';
    }
}
