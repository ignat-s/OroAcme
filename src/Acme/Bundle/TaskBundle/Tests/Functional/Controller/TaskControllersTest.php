<?php

namespace Acme\Bundle\TaskBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Oro\Bundle\TestFrameworkBundle\Test\ToolsAPI;
use Oro\Bundle\TestFrameworkBundle\Test\Client;

/**
 * @outputBuffering enabled
 * @db_isolation
 * @db_reindex
 */
class TaskControllersTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient(array(), ToolsAPI::generateBasicHeader());
    }

    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->client->generate('acme_task_create'));
        $form = $crawler->selectButton('Save and Close')->form();
        $form['acme_task[status]'] = 'open';
        $form['acme_task[title]'] = 'New task';
        $form['acme_task[description]'] = 'New description';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 200, 'text/html; charset=UTF-8');
        $this->assertContains("Task Saved", $crawler->html());
    }

    /**
     * @depends testCreate
     */
    public function testUpdate()
    {
        $result = ToolsAPI::getEntityGrid(
            $this->client,
            'acme_task_grid',
            array(
                'acme_task_grid[_filter][owner][value]' => 'John Doe'
            )
        );

        ToolsAPI::assertJsonResponse($result, 200);

        $result = ToolsAPI::jsonToArray($result->getContent());
        $result = reset($result['data']);

        $crawler = $this->client->request(
            'GET',
            $this->client->generate('acme_task_update', array('id' => $result['id']))
        );

        $form = $crawler->selectButton('Save and Close')->form();
        $form['acme_task[status]'] = 'in_progress';
        $form['acme_task[title]'] = 'Task updated';
        $form['acme_task[description]'] = 'Description updated';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 200, 'text/html; charset=UTF-8');
        $this->assertContains("Task Saved", $crawler->html());
    }

    /**
     * @depends testUpdate
     */
    public function testView()
    {
        $result = ToolsAPI::getEntityGrid(
            $this->client,
            'acme_task_grid',
            array(
                'acme_task_grid[_filter][owner][value]' => 'John Doe'
            )
        );

        ToolsAPI::assertJsonResponse($result, 200);

        $result = ToolsAPI::jsonToArray($result->getContent());
        $result = reset($result['data']);

        $this->client->request(
            'GET',
            $this->client->generate('acme_task_view', array('id' => $result['id']))
        );

        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 200, 'text/html; charset=UTF-8');
        $this->assertContains('Task updated - Tasks - Acme', $result->getContent());
    }

    /**
     * @depends testUpdate
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->client->generate('acme_task_index'));
        $result = $this->client->getResponse();
        ToolsAPI::assertJsonResponse($result, 200, 'text/html; charset=UTF-8');
        $this->assertContains('Task updated', $result->getContent());
    }
}
