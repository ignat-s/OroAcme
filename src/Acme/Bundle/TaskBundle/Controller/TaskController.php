<?php

namespace Acme\Bundle\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     */
    public function indexAction()
    {
        return array();
    }
}
