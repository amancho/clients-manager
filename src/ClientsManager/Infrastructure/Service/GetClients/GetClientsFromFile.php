<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GetClients;

use iSalud\ClientsManager\Application\Command\RenewClients\ImportClientsFromFile;

final class GetClientsFromFile implements ImportClientsFromFile
{
    public static function create(): self
    {
        return new self();
    }

    public function execute(string $filePath): array
    {
        return [];
    }
}