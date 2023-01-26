<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

interface ImportClientsFromFile
{
    public function execute(string $filePath): array;
}