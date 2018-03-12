<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ControllerStatusTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ControllerStatusTest extends WebTestCase
{
    /**
     * @param $url
     * @dataProvider urlProvider
     */
    public function testPageAsAnonymousIsSuccessfull($url)
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, $url);

        static::assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @param $url
     * @dataProvider protectedUrlProvider
     */
    public function testPageAsAnonymousIsErrored($url)
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, $url);

        static::assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * @param $url
     * @dataProvider protectedUrlProvider
     */
    public function testPageAsUserIsSuccessfull($url)
    {
        $client = self::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));
        $client->request(Request::METHOD_GET, $url);

        static::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        //static::assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @return \Generator
     */
    public function urlProvider()
    {
        yield ['/login'];
    }

    /**
     * @return \Generator
     */
    public function protectedUrlProvider()
    {
        yield ['/'];
        yield ['/tasks'];
        yield ['/users'];
        yield ['/users/create'];
    }
}