<?php

namespace iSalud\ClientsManager\Application\Service\ClientTransformer;

use iSalud\ClientsManager\Domain\Client\Client;
use iSalud\ClientsManager\Domain\Client\ClientCollection;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientCompanyName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientEmail;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientId;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientPhone;
use iSalud\Shared\Domain\Error\InvalidCollectionItemType;

final class ClientCollectionTransformer
{

    /**
     * @throws InvalidCollectionItemType
     */
    public function transform(array $clients): ClientCollection
    {
        $transformedClients = [];

        foreach ($clients as $client) {
            if (!$this->isValidClient($client)) {
                continue;
            }

            $transformedClients[] = Client::create(
                new ClientId($client['id'] ?? ''),
                new ClientName($client['name'] ?? ''),
                new ClientEmail($client['email'] ?? ''),
                new ClientPhone($client['phone'] ?? ''),
                new ClientCompanyName($client['company'] ?? '')
            );
        }

        return new ClientCollection(...$transformedClients);
    }

    private function isValidClient(array $client): bool
    {
        return (array_key_exists('name', $client)
            && (array_key_exists('email', $client) || array_key_exists('phone', $client)));
    }

    public static function create(): self
    {
        return new self();
    }
}