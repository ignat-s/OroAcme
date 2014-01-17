<?php

namespace Acme\Bundle\TaskBundle\Tests\Functional\Controller\Api\Rest;

use Acme\Bundle\TaskBundle\Entity\Task;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\TestFrameworkBundle\Test\ToolsAPI;
use Oro\Bundle\TestFrameworkBundle\Test\Client;

/**
 * @outputBuffering enabled
 * @db_isolation
 */
class RestTaskACLTest extends WebTestCase
{
    const USER_NAME = 'user_wo_permissions';
    const USER_PASSWORD = 'user_api_key';

    /** @var Client */
    protected $client;

    /** @var Task */
    protected static $taskId;

    protected static $hasLoaded = false;

    public function setUp()
    {
        $this->client = static::createClient(
            array(),
            ToolsAPI::generateWsseHeader(self::USER_NAME, self::USER_PASSWORD)
        );

        if (!self::$hasLoaded) {
            $this->client->appendFixtures(__DIR__ . DIRECTORY_SEPARATOR . 'DataFixtures');
            self::$taskId = $this->client->getContainer()
                ->get('doctrine')
                ->getManager()
                ->getRepository('AcmeTaskBundle:Task')
                ->findOneByStatus('open')
                ->getId();
        }
        self::$hasLoaded = true;
    }

    public function testCreate()
    {
        $request = array(
            'task' => array(
                'title' => 'Task',
                'description' => 'Description',
                'status' => 'closed'
            )
        );

        $this->client->request('POST', $this->client->generate('acme_api_post_task'), $request);
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 403);
    }

    public function testCget()
    {
        $this->client->request('GET', $this->client->generate('acme_api_get_tasks'));
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 403);
    }

    public function testGet()
    {
        $this->client->request('GET', $this->client->generate('acme_api_get_task', array('id' => self::$taskId)));
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 403);
    }

    public function testPut()
    {
        $updatedTask = array('title' => 'Updated title');
        $this->client->request(
            'PUT',
            $this->client->generate('acme_api_put_task', array('id' => self::$taskId)),
            array('task' => $updatedTask)
        );
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 403);
    }

    public function testDelete()
    {
        $this->client->request(
            'DELETE',
            $this->client->generate('acme_api_delete_task', array('id' => self::$taskId))
        );
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 403);
    }
}
