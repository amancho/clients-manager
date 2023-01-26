<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GetClients;

use iSalud\ClientsManager\Application\Command\RenewClients\ImportClientsFromApi;

final class GetClientsFromApi implements ImportClientsFromApi
{
    public function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function execute(): array
    {
        return [];
    }
}