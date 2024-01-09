<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    public function __construct(protected ValidatorInterface $validator)
    {
        //$this->populate();
    }

    public function validate($dto)
    {
        $errors = $this->validator->validate($dto);

        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            throw new Exception($message->getMessage());
        }

    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function autoValidateRequest(): bool
    {
        return true;
    }
}
