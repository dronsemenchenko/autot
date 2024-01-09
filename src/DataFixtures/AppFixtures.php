<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\City;
use App\Entity\Product;
use App\Entity\Storage;
use App\Entity\ProductInStorage;
use App\Entity\PurshaseStatus;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $citys = ['Москва', 'Санкт-Петербург', 'Ростов-на-Дону', 'Казань'];
        for ($i = 0; $i < sizeof($citys); $i++) {
            $city = new City();
            $city->setName($citys[$i]);
            $manager->persist($city);
        }

        $purshaseStatuss = ['Ожидает обработки', 'Ожидает отправки', 'Отправлено', 'Выдано клиенту'];
        for ($i = 0; $i < sizeof($purshaseStatuss); $i++) {
            $purshaseStatus = new PurshaseStatus();
            $purshaseStatus->setName($purshaseStatuss[$i]);
            $manager->persist($purshaseStatus);
        }

        $products = ['Аккумулятор Solite 44B19LBH', 'Аккумулятор Sznajder 54570', 'Инструмент, разное Bahco 9048250', 'Ручной инструмент Stanley 083179'];
        for ($i = 0; $i < sizeof($products); $i++) {
            $product = new Product();
            $product->setName($products[$i]);
            $manager->persist($product);
        }

        $manager->flush();

        $storages = [
            [
                'name' => 'Балашиха склад №1',
                'city' => 'Москва',
                'street' => 'Ленина',
                'houseNum' => 12
            ],
            [
                'name' => 'Ростов Cклад №2',
                'city' => 'Ростов-на-Дону',
                'street' => 'Вакуленко',
                'houseNum' => 12
            ],
            [
                'name' => 'Казань склад №3',
                'city' => 'Казань',
                'street' => 'Аигель',
                'houseNum' => 33
            ],
        ];
        for ($i = 0; $i < sizeof($storages); $i++) {
            $storage = new Storage();
            $storage->setName($storages[$i]['name']);
            $storage->setStreet($storages[$i]['street']);
            $storage->setHouseNum($storages[$i]['houseNum']);
            $city = $manager->getRepository(City::class)->findOneByName($storages[$i]['city']);
            $storage->setCity($city);
            $manager->persist($storage);
        }

        $manager->flush();

        $productInStorages = [
            [
                'storage' => 'Балашиха склад №1',
                'product' => 'Аккумулятор Solite 44B19LBH',
                'amount' => 100
            ],
            [
                'storage' => 'Балашиха склад №1',
                'product' => 'Аккумулятор Sznajder 54570',
                'amount' => 100
            ],
            [
                'storage' => 'Балашиха склад №1',
                'product' => 'Инструмент, разное Bahco 9048250',
                'amount' => 100
            ],
            [
                'storage' => 'Балашиха склад №1',
                'product' => 'Ручной инструмент Stanley 083179',
                'amount' => 100
            ],
            [
                'storage' => 'Ростов Cклад №2',
                'product' => 'Аккумулятор Solite 44B19LBH',
                'amount' => 200
            ],
            [
                'storage' => 'Ростов Cклад №2',
                'product' => 'Ручной инструмент Stanley 083179',
                'amount' => 200
            ],
            [
                'storage' => 'Казань склад №3',
                'product' => 'Аккумулятор Solite 44B19LBH',
                'amount' => 300
            ]
        ];

        for ($i = 0; $i < sizeof($productInStorages); $i++) {
            $productInStorage = new ProductInStorage();
            $storage = $manager->getRepository(Storage::class)->findOneByName($productInStorages[$i]['storage']);
            $productInStorage->setStorage($storage);
            $product = $manager->getRepository(Product::class)->findOneByName($productInStorages[$i]['product']);
            $productInStorage->setProduct($product);
            $productInStorage->setAmount($productInStorages[$i]['amount']);

            $manager->persist($productInStorage);
        }


        $manager->flush();
    }
}
