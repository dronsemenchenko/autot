<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CityRepository;
use App\Repository\StorageRepository;

class ProductTest extends WebTestCase
{

    static $client;
    static $container;

    protected function setUp(): void
    {
        self::$client = static::createClient();
        self::$container = static::getContainer();
    }

    public function testList(): void
    {

        self::$client->request('GET', '/api/product/list');
        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertResponseIsSuccessful();
        $this->assertCount(
            4,
            json_decode($response->getContent(), true)
        );
    }

    public function testListByCity(): void
    {
        $cityRepository =  self::$container->get(CityRepository::class);
        $city = $cityRepository->findOneByName('Москва');

        self::$client->request('GET', '/api/product/list/city/' . $city->getId());
        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertResponseIsSuccessful();
        $this->assertCount(
            4,
            json_decode($response->getContent(), true)
        );
    }

    public function testListByCityEmpty(): void
    {
        $cityRepository =  self::$container->get(CityRepository::class);
        $city = $cityRepository->findOneByName('Санкт-Петербург');

        self::$client->request('GET', '/api/product/list/city/' . $city->getId());
        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertResponseIsSuccessful();
        $this->assertCount(
            0,
            json_decode($response->getContent(), true)
        );
    }

    public function testListByStorage(): void
    {
        $storageRepository =  self::$container->get(StorageRepository::class);
        $storage = $storageRepository->findOneByName('Казань склад №3');

        self::$client->request('GET', '/api/product/list/storage/' . $storage->getId());
        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(200, $response->getStatusCode());

        $this->assertResponseIsSuccessful();
        $this->assertCount(
            1,
            json_decode($response->getContent(), true)
        );
    }
}
