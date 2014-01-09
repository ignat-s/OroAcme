<?php

namespace Acme\Bundle\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\UserBundle\Entity\User;

use Acme\Bundle\TaskBundle\Entity\Task;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     *
     *
     * @Route(
     *      ".{_format}",
     *      name="acme_task_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="acme_task_view", requirements={"id"="\d+"})
     * @Template
     */
    public function viewAction(Task $task)
    {
        return array('entity' => $task);
    }

    /**
     * @Route("/create", name="acme_task_create")
     * @Template("AcmeTaskBundle:Task:update.html.twig")
     */
    public function createAction()
    {
        $task = new Task();

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
                        'route' => 'acme_task_index'
                    )
                );
            }
        }

        return array(
            'entity' => $task,
            'form' => $form->createView(),
        );
    }
}
