<?php

namespace iSalud\ClientsManager\Domain\Client;

use iSalud\ClientsManager\Domain\Client\ValueObject\ClientCompanyName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientEmail;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientId;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientPhone;

final class Client
{
    public function __construct(
        private readonly ClientId          $clientId,
        private readonly ClientName        $clientName,
        private readonly ClientEmail       $clientEmail,
        private readonly ClientPhone       $clientPhone,
        private readonly ClientCompanyName $clientCompanyName
    )
    {
    }

    public static function create(
        ClientId          $clientId,
        ClientName        $clientName,
        ClientEmail       $clientEmail,
        ClientPhone       $clientPhone,
        ClientCompanyName $clientCompanyName
    ): Client
    {
        return new self($clientId, $clientName, $clientEmail, $clientPhone, $clientCompanyName);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name()->value(),
            'email' => $this->email()->value(),
            'phone' => $this->phone()->value(),
            'companyName' => $this->companyName()->value()
        ];
    }

    public function id(): ClientId
    {
        return $this->clientId;
    }

    public function name(): ClientName
    {
        return $this->clientName;
    }

    public function email(): ClientEmail
    {
        return $this->clientEmail;
    }

    public function phone(): ClientPhone
    {
        return $this->clientPhone;
    }

    public function companyName(): ClientCompanyName
    {
        return $this->clientCompanyName;
    }
}