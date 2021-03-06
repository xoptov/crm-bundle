<?php

namespace Perfico\CRMBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class ChannelControllerTest extends AuthenticateControllerTest
{
    public function testIndexAction()
    {
        $token = json_decode(self::$json)->token;
        $url = 'http://' . self::$baseDomain . '/api/channels';

        $client = $this->createClient();
        $client->request('GET', $url, array('token' => $token));

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
} 