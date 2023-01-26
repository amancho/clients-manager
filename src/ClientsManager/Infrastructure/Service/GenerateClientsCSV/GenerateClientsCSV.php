<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GenerateClientsCSV;

use iSalud\ClientsManager\Application\Command\RenewClients\ExportClientsToFile;
use iSalud\ClientsManager\Domain\Client\ClientCollection;

final class GenerateClientsCSV implements ExportClientsToFile
{
    private const DESTINATION_PATH = '/var/www/tmp/';


    public function execute(ClientCollection $clientCollection, ?string $destinationFileName): string
    {
        return '';
    }

    public static function create(): self
    {
        return new self();
    }
}
