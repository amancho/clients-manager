<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

interface ImportClientsFromApi
{
    public function execute(): array;
}