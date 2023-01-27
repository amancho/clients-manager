<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

use iSalud\ClientsManager\Domain\Client\ClientCollection;

interface ImportClientsFromApi
{
    public function execute(): ClientCollection;
}