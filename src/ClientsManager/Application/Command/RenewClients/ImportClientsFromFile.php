<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

use iSalud\ClientsManager\Domain\Client\ClientCollection;

interface ImportClientsFromFile
{
    public function execute(string $filePath): ClientCollection;
}