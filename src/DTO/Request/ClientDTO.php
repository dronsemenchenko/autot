<?php

namespace App\DTO\Request;

//use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueEmail;
use App\Entity\Client;

final class ClientDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        max: 11,
        minMessage: 'Your phone must be at least {{ limit }} characters long',
        maxMessage: 'Your phone cannot be longer than {{ limit }} characters'
    )]
    #[Assert\Regex(pattern:"/^[0-9]*$/", message:"number_only") ]
    private string $phone;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[UniqueEmail(
        entityClass: Client::class,
        field: 'email'
    )]
    private string $email;

    private DeliveryAddressDTO $deliveryAddress;

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}