<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurshaseStatusTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        
        $client->request('GET', '/api/purshase/status/list');
        $response = $client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertResponseIsSuccessful();
        $this->assertCount(
            4,
            json_decode($response->getContent())
        );
    }

}
