<?php

namespace iSalud\ClientsManager\Application\Command\RenewClients;

use Exception;
use iSalud\ClientsManager\Domain\Client\Client;
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
        $clientCollection = $this->getClientsFromApi->execute();

        if ($clientCollection->isNotEmpty() && !empty($this->sourceFilePath)) {
            $clientsFromFile = $this->getClientsFromFile->execute($this->sourceFilePath);

            /* @var Client $client */
            foreach ($clientsFromFile as $client) {
                $clientCollection->add($client);
            }
        }

        if ($clientCollection->isEmpty()) {
            throw new \Exception('ERROR :: Sorry, clients could not been loaded');
        }

        return $this->getSuccessMessage(
            $clientCollection,
            $this->generateCSV($clientCollection)
        );
    }

    private function getSuccessMessage(ClientCollection $clientCollection, string $generatedCSVFile): string
    {
        return \sprintf('File %s was successfully generated with %s clients', $generatedCSVFile, $clientCollection->count());
    }

    private function generateCSV(ClientCollection $clientCollection): string
    {
        return $this->exportClientsToFile->execute($clientCollection, $this->destinationFileName);
    }
}