<?php

namespace App\Model;

use Exception;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Purshase;
use App\Entity\Client;
use App\Entity\PurshaseProduct;
use App\Entity\PurshaseStatus;
use App\Entity\DeliveryAddress;
use App\Repository\PurshaseRepository;
use App\Repository\DeliveryAddressRepository;
use App\Repository\ProductInStorageRepository;
use App\Repository\PurshaseStatusRepository;
use App\Repository\CityRepository;

use App\DTO\Request\ClientDTO;
use App\DTO\Request\DeliveryAddressDTO;
use App\DTO\Request\PurshaseProductDTO;
use App\DTO\Request\Transformer\ClientRequestDtoTransformer;
use App\DTO\Request\Transformer\DeliveryAddressesRequestDtoTransformer;
use App\DTO\Request\Transformer\PurshaseProductRequestDtoTransformer;

use App\Service\Validator;

// DDD почти Агрегат)
class PurshaseModel {

    private Client $client;
    private Purshase $purshase;
    private array $purshaseProducts;
    private DeliveryAddress $deliveryAddress;

    // с одной стороны очень много зависимостей на репозитории и можно их сократить на одну ManagerRegistry $doctrine
    // но тогда VSCODE не поддерживает подсветку
    public function __construct(
        //private ManagerRegistry $doctrine,
        private Validator $validator,
        private PurshaseRepository $purshaseRepository,
        private DeliveryAddressRepository $deliveryAddressRepository,
        private ProductInStorageRepository $productInStorageRepository,
        private CityRepository $cityRepository,
        private PurshaseStatusRepository $statusRepository,
        private ClientRequestDtoTransformer $clientRequestDtoTransformer,
        private DeliveryAddressesRequestDtoTransformer $deliveryAddressesRequestDtoTransformer,
        private PurshaseProductRequestDtoTransformer $purshaseProductRequestDtoTransformer
    ) {
        $this->purshaseProducts=[];
    }

    public function create(Request $request): Purshase
    {
        $purshase = new Purshase();
        $this->setPurshase($purshase);
        $this->prepare($request, $purshase);
        return $this->build($purshase);
    }

    private function prepare(Request $request){
        $data = json_decode($request->getContent(), true);
        
        $this->makeClient($data["client"]);
        $this->makeDeliveryAddress($data["client"]["deliveryAddress"]);
        $this->makePurshaseProducts($data["purshaseProducts"]);
    }

    private function build(Purshase $purshase): Purshase
    {        
        $purshase->setExtTrackNum(null);
        $purshase->setClient($this->getClient());
        $purshase->setPurshaseStatus($this->calcPurshaseStatus());
        $purshase->setCreatedAt(new \DateTimeImmutable());
        $purshase->setPriceDelivery(null);
        foreach($this->getPurshaseProducts() as $purshaseProduct){
            $purshase->addPurshaseProduct($purshaseProduct);
        }
        $this->purshaseRepository->save($purshase, 1);
        return $purshase;
    }

    private function getClient(): Client
    {
        return $this->client;
    }

    private function setClient(Client $client): void
    {
        $this->client = $client;
    }

    private function getPurshaseProducts(): array
    {
        return $this->purshaseProducts;
    }

    private function addPurshaseProduct(PurshaseProduct $purshaseProduct): void 
    {
        $this->purshaseProducts[] = $purshaseProduct;
    }
    
    private function getDeliveryAddress(): DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    private function setDeliveryAddress(DeliveryAddress $deliveryAddress): void 
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    private function calcPurshaseStatus(): PurshaseStatus
    {
        $deliveryCity = $this->getDeliveryAddress()->getCity();
        foreach($this->getPurshaseProducts() as $purshaseProduct){
            if($deliveryCity!==$purshaseProduct->getProductInStorage()->getStorage()->getCity()){
                $flag_other_city = 1;
            }
        }

        if(!isset($flag_other_city)){
            return $this->statusRepository->findOneByName('Ожидает отправки');
        }else{
            return $this->statusRepository->findOneByName('Ожидает обработки');
        }        
    }

    private function makeClient(array $data): Client
    {
        $clientDTO = new ClientDTO;

        $clientDTO->setEmail($data["email"]);
        $clientDTO->setPhone($data["phone"]);
        $this->validator->validate($clientDTO);

        $client = $this->clientRequestDtoTransformer->transformToObject($clientDTO);
        $this->setClient($client);        
        return $client;
    }

    private function makeDeliveryAddress(array $data): DeliveryAddress
    {
        $deliveryAddressDTO = new DeliveryAddressDTO;
        $city = $this->cityRepository->find($data["city"]);
        $deliveryAddressDTO->setCity($city);
        $deliveryAddressDTO->setStreet($data["street"]);
        $deliveryAddressDTO->setHouseNum($data["houseNum"]);
        $deliveryAddressDTO->setApartmentNum($data["apartmentNum"]);
        $deliveryAddressDTO->setClient($this->getClient());
        $this->validator->validate($deliveryAddressDTO);

        $deliveryAddress = $this->deliveryAddressesRequestDtoTransformer->transformToObject($deliveryAddressDTO);
        $this->setDeliveryAddress($deliveryAddress);        
        $this->deliveryAddressRepository->save($deliveryAddress);
        return $deliveryAddress;
    }

    private function makePurshaseProducts(array $data): void
    {
        $data = $this->uniqPurshaseProducts($data);
        $purshaseProductDTO = new PurshaseProductDTO();
        foreach ($data as $product){
            $purshaseProductDTO->setPurshase($this->getPurshase());
            $productInStorage = $this->productInStorageRepository->find($product["id"]);
            if(!$productInStorage){
                // явная попытка подделать данные, потому обычный Exception вместо Validation. Дальше тут можно писать в лог таких попыток или иначе сигнализировать
                throw new Exception('Не обнаружен продукт на складе c id ='.$product["id"]);
            }

            $purshaseProductDTO->setProductInStorage($productInStorage);
            $amount = (int)$product["amount"];

            // change on storage 
            // не уверен что тут правильно смешивать логику. Хз куда правильно это вынести.
            // можно в Event например, но не уверен что размазывание логики тут хорошо. Всё таки списывание со склада, читай бронирование наверное должно быть рядом с тем местом кто является его инициатором. но не уверен

            $productInStorage->setAmount(
                ($productInStorage->getAmount() - $amount)
            );

            $this->productInStorageRepository->save($productInStorage);
            $purshaseProductDTO->setAmount($amount);
            $this->validator->validate($purshaseProductDTO);
            $purshaseProduct = $this->purshaseProductRequestDtoTransformer->transformToObject($purshaseProductDTO);
            $this->addPurshaseProduct($purshaseProduct);
        }
    }

    private function uniqPurshaseProducts(array $data): array
    {
        $idArr = [];
        foreach($data as $d){
            $idArr[]=$d['id'];
        }
        if(count(array_unique($idArr))!==count($data)){
            // опять явная попытка подделать данные, либо тупит фронт и шлёт дубликаты.
            // возможно также стоит вынести в другое место.

            throw new Exception('Обнаружен дубликат заказываемых продуктов');
        }
        return $data;
    }
    
    /**
     * Get the value of purshase
     *
     * @return Purshase
     */
    public function getPurshase(): Purshase
    {
        return $this->purshase;
    }

    /**
     * Set the value of purshase
     *
     * @param Purshase $purshase
     *
     * @return self
     */
    public function setPurshase(Purshase $purshase): self
    {
        $this->purshase = $purshase;

        return $this;
    }
}