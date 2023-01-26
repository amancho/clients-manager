<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

use iSalud\ClientsManager\Domain\Client\ClientCollection;

interface ExportClientsToFile
{
    public function execute(ClientCollection $clientCollection, ?string $destinationDestinationFileName): string;
}