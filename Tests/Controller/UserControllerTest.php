<?php

namespace Perfico\CRMBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends AuthenticateControllerTest
{
    public function testGetNotPaginatedAction()
    {
        $token = json_decode(self::$json)->token;
        $url = 'http://' . self::$baseDomain . '/api/users-list';

        $client = $this->createClient();
        $client->request('GET', $url, array('token' => $token));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testIndexAction()
    {
        $token = json_decode(self::$json)->token;
        $url = 'http://' . self::$baseDomain . '/api/users-list/1/10';

        $client = $this->createClient();
        $client->request('GET', $url, array('token' => $token));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetCurrentAction()
    {
        $token = json_decode(self::$json)->token;
        $url = 'http://' . self::$baseDomain . '/api/users/current';

        $client = $this->createClient();
        $client->request('GET', $url, array('token' => $token));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
} 