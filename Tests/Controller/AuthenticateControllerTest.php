<?php

namespace Perfico\CRMBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateControllerTest extends WebTestCase
{
    /** @var string */
    protected static $json;

    protected static $baseDomain;

    public static function setUpBeforeClass()
    {
        $client = self::createClient();
        self::$baseDomain = $client->getContainer()->getParameter('base_domain');

        $username = $client->getContainer()->getParameter('test_username');
        $password = $client->getContainer()->getParameter('test_password');

        $url = 'http://' . self::$baseDomain . '/api/login';
        $client->request('POST', $url, array('username' => $username, 'password' => $password));
        self::$json = $client->getResponse()->getContent();
    }

    public function testLoginAction()
    {
        $this->assertJson(self::$json);
        $token = json_decode(self::$json)->token;
        $this->assertNotEmpty($token);
    }
} 