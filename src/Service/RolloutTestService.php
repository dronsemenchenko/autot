<?php
namespace App\Service;

use App\Entity\Purshase;
use App\Repository\PurshaseRepository;
use App\Repository\PurshaseProductRepository;
use App\Repository\ProductInStorageRepository;
use App\Repository\ClientRepository;
use App\Repository\DeliveryAddressRepository;

class RolloutTestService
{
    public function __construct(
        //private ManagerRegistry $registry, 
        private PurshaseRepository $purshaseRepository,
        private PurshaseProductRepository $purshaseProductRepository,
        private ClientRepository $clientRepository,
        private DeliveryAddressRepository $deliveryAddressRepository,
        private ProductInStorageRepository $productInStorageRepository,
    )
    {
        
    }

    public function testRollback(Purshase $purshase){
        
        $products = $purshase->getPurshaseProducts();
        foreach($products as $product){
            $productInStorage = $product->getProductInStorage();
            $productInStorage->setAmount($productInStorage->getAmount()+$product->getAmount());
            $this->productInStorageRepository->save($productInStorage);
            $this->purshaseProductRepository->remove($product);
        }

        $deliveryAddresses = $purshase->getClient()->getDeliveryAddresses();
        foreach($deliveryAddresses as $address){
            $this->deliveryAddressRepository->remove($address);
        }
        $this->clientRepository->remove($purshase->getClient());
        $this->purshaseRepository->remove($purshase, 1);
    }
}
