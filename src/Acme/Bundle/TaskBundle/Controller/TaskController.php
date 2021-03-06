<?php

namespace Acme\Bundle\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\UserBundle\Entity\User;

use Acme\Bundle\TaskBundle\Entity\Task;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @Route(
     *      ".{_format}",
     *      name="acme_task_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     *      id="acme_task_index",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="acme_task_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="acme_task_view",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="VIEW"
     * )
     */
    public function viewAction(Task $task)
    {
        return array('entity' => $task);
    }

    /**
     * @Route("/create", name="acme_task_create")
     * @Template("AcmeTaskBundle:Task:update.html.twig")
     * @Acl(
     *      id="acme_task_create",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="CREATE"
     * )
     */
    public function createAction()
    {
        $task = new Task();

        $assigneeId = (int) $this->getRequest()->get('assigneeId');
        if ($assigneeId) {
            $assignee = $this->getDoctrine()->getManager()->find('OroUserBundle:User', $assigneeId);
            if ($assignee) {
                $task->setAssignee($assignee);
            }
        }

        $defaultStatus = $this->getDoctrine()->getManager()->find('AcmeTaskBundle:TaskStatus', 'open');
        $task->setStatus($defaultStatus);

        $securityToken = $this->get('security.context')->getToken();
        if ($securityToken->getUser() instanceof User) {
            $task->setOwner($securityToken->getUser());
        }

        return $this->update($task);
    }

    /**
     * @Route("/update/{id}", name="acme_task_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="acme_task_update",
     *      type="entity",
     *      class="AcmeTaskBundle:Task",
     *      permission="EDIT"
     * )
     */
    public function updateAction(Task $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Task $task
     * @return array
     */
    protected function update(Task $task)
    {
        $request = $this->getRequest();
        $form = $this->createForm($this->get('acme_task.form.type.task'), $task);

        if ('POST' == $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($task);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('acme.task.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'acme_task_update',
                        'parameters' => array('id' => $task->getId()),
                    ),
                    array(
                        'route' => 'acme_task_view',
                        'parameters' => array('id' => $task->getId()),
                    )
                );
            }
        }

        return array(
            'entity' => $task,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/assigned/{assigneeId}", name="acme_task_assigned_tasks", requirements={"assigneeId"="\d+"})
     * @ParamConverter("assignee", class="OroUserBundle:User", options={"id" = "assigneeId"})
     * @Template()
     * @AclAncestor("acme_task_index")
     */
    public function assignedTasksAction(User $assignee)
    {
        return array(
            'assignee' => $assignee
        );
    }
}
