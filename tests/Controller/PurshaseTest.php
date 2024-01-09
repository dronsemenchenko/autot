<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\RolloutTestService;
use App\Repository\PurshaseRepository;
use App\Repository\CityRepository;
use App\Repository\ProductInStorageRepository;

class PurshaseTest extends WebTestCase
{

    static $client;
    static $container;

    protected function setUp(): void
    {
        self::$client = static::createClient();
        self::$container = static::getContainer();
    }

    public function testCreateFailed(): void
    {
        self::$client->jsonRequest('POST', '/api/purshase', [
            "test" => "test"
        ]);

        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(500, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                "status" => "failed",
                "error" => "Undefined array key \"client\""
            ]),
            $response->getContent()
        );
    }

    public function testCreateInValidEmail(): void
    {
        self::$client->jsonRequest('POST', '/api/purshase', [
            "client" => [
                "email" => "testest.ru",
                "phone" => "89271111111",
                "deliveryAddress" => [
                    "city" => 27,
                    "street" => "Вернадского",
                    "houseNum" => 11,
                    "apartmentNum" => 11
                ]
            ],
            "purshaseProducts" => [
                [
                    "id" => 3,
                    "amount" => 10
                ],
                [
                    "id" => 4,
                    "amount" => 20
                ],
                [
                    "id" => 6,
                    "amount" => 30
                ]
            ]
        ]);

        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(500, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                "status" => "failed",
                "error" => "The email \"testest.ru\" is not a valid email."
            ]),
            $response->getContent()
        );
    }

    public function testCreateValid(): void
    {
        $cityRepository =  self::$container->get(CityRepository::class);
        $city = $cityRepository->findOneByName('Ростов-на-Дону');

        $productInStorageRepository =  self::$container->get(ProductInStorageRepository::class);
        $productInStorage1 = $productInStorageRepository
            ->findOneByStorageAndProduct(product: 'Инструмент, разное Bahco 9048250', storage: 'Балашиха склад №1');
        $productInStorage2 = $productInStorageRepository
            ->findOneByStorageAndProduct(product: 'Ручной инструмент Stanley 083179', storage: 'Балашиха склад №1');
        $productInStorage3 = $productInStorageRepository
            ->findOneByStorageAndProduct(product: 'Аккумулятор Solite 44B19LBH', storage: 'Ростов Cклад №2');

        self::$client->jsonRequest('POST', '/api/purshase', [
            "client" => [
                "email" => "test@test.ru",
                "phone" => "89271111111",
                "deliveryAddress" => [
                    "city" => $city->getId(),
                    "street" => "Вернадского",
                    "houseNum" => 11,
                    "apartmentNum" => 11
                ]
            ],
            "purshaseProducts" => [
                [
                    "id" => $productInStorage1->getId(),
                    "amount" => 10
                ],
                [
                    "id" => $productInStorage2->getId(),
                    "amount" => 20
                ],
                [
                    "id" => $productInStorage3->getId(),
                    "amount" => 30
                ]
            ]
        ]);

        $response = self::$client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());
        $this->assertSame(201, $response->getStatusCode());

        $this->assertStringContainsString("CREATED", $response->getContent());
        $this->assertResponseIsSuccessful();


        // rollback
        $purshaseRepository = self::$container->get(PurshaseRepository::class);
        $data = json_decode($response->getContent(), true);
        $purshase = $purshaseRepository->find($data['purshase_id']);

        $rolloutTestService = self::$container->get(RolloutTestService::class);
        $rolloutTestService->testRollback($purshase);

        
    }
}
