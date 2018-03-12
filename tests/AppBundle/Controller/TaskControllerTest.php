<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
/**
 * Class TaskControllerTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class TaskControllerTest extends WebTestCase
{
    public function testTaskList()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks');

        static::assertEquals(20, $crawler->filter('.thumbnail')->count());
    }

    public function testTaskCreate()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = "Test de task";
        $form['task[content]'] = "Contenu de la task";

        $client->submit($form);

        $crawler = $client->followRedirect();

        static::assertEquals(1, $crawler->filter('html:contains("Test de task")')->count());
        static::assertEquals(1, $crawler->filter('html:contains("Contenu de la task")')->count());
    }

    public function testTaskEdit()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks/1/edit');

        static::assertEquals(1, $crawler->filter('html:contains("Tache créée par Anonyme")')->count());

        $crawler = $client->request(Request::METHOD_GET, '/tasks/21/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = "Test de task";
        $form['task[content]'] = "Edition - Contenu de la task";

        static::assertEquals(1, $crawler->filter('html:contains("Tache créée par admin")')->count());
        $client->submit($form);

        $crawler = $client->followRedirect();

        static::assertEquals(1, $crawler->filter('html:contains("Test de task")')->count());
        static::assertEquals(1, $crawler->filter('html:contains("Edition - Contenu de la task")')->count());
    }

    public function testTaskToggle()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks');

        $form = $crawler->filter('.btn.btn-success')
            ->last()
            ->form();

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        static::assertEquals(7, $crawler->filter('.glyphicon-ok')->count());
    }

    public function testTaskDeleteFail()
    {
        $client = $this->getClient();

        $crawler = $client->request(Request::METHOD_GET, '/tasks/21/delete/csrf');
        $crawler = $client->followRedirect();

        static::assertEquals(21, $crawler->filter('.thumbnail')->count());
    }

    public function testTaskDelete()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/tasks');

        $link = $crawler->filter('a.btn.btn-danger')
            ->last()
            ->link();

        $crawler = $client->click($link);
        $crawler = $client->followRedirect();

        static::assertEquals(20, $crawler->filter('.thumbnail')->count());
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function getClient()
    {
        return self::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));
    }
}