<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

use Exception;
use iSalud\ClientsManager\Domain\Client\ClientCollection;

final class RenewClientsCommand
{
    public function __construct(
        private readonly ImportClientsFromApi  $getClientsFromApi,
        private readonly ImportClientsFromFile $getClientsFromFile,
        private readonly ExportClientsToFile   $exportClientsToFile,
        private readonly ?string               $sourceFilePath = null,
        private readonly ?string               $destinationFileName = null
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(): string
    {
        $clients = $this->getClientsFromApi->execute();

        if (!empty($clients)) {
            $clientsFromFile = $this->getClientsFromFile->execute($this->sourceFilePath);
            $clients = \array_merge($clients, $clientsFromFile);
        }

        if (empty($clients)) {
            throw new \Exception('ERROR :: Sorry, clients could not been loaded');
        }

        return '';
    }

    private function generateCSV(ClientCollection $clientCollection): string
    {
        return (string)$clientCollection->count();
    }
}