<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserControllerTest extends WebTestCase
{
    public function testUserList()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/users');

        static::assertEquals(2, $crawler->filter('tbody tr')->count());
    }

    public function testUserCreate()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = "Test";
        $form['user[password][first]'] = "test";
        $form['user[password][second]'] = "test";
        $form['user[email]'] = "test@website.net";
        $client->submit($form);

        $crawler = $client->followRedirect();

        static::assertEquals(1, $crawler->filter('html:contains("test@website.net")')->count());
        static::assertEquals(3, $crawler->filter('tbody tr')->count());
    }

    public function testUserEdit()
    {
        $client = $this->getClient();
        $crawler = $client->request(Request::METHOD_GET, '/users/3/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = "Test";
        $form['user[email]'] = "test-edit@website.net";
        $client->submit($form);

        $crawler = $client->followRedirect();

        static::assertEquals(1, $crawler->filter('html:contains("test-edit@website.net")')->count());
        static::assertEquals(3, $crawler->filter('tbody tr')->count());
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