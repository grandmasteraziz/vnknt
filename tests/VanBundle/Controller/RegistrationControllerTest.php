<?php

// tests/UserBundle/Controller/RegistrationControllerTest.php

namespace Tests\VaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testPostRegsiterNewUser()
    {
        $data = [
            'username' => 'matko',
            'email' => 'matko@gmail.com',
            'plainPassword' => [
                'first' => 'test123', 'second' => 'test123'
            ]
        ];

        $client = static::createClient();
        $client->request(
            'POST', '/users/register', array(), array(),
            array(
                'CONTENT_TYPE' => 'application/json',
            ),
            json_encode($data)
        );

        $this->assertEquals(
            201, $client->getResponse()->getStatusCode()
        );
    }
}