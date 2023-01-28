<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GenerateClientsCSV;

use iSalud\ClientsManager\Application\Command\RenewClients\ExportClientsToFile;
use iSalud\ClientsManager\Domain\Client\Client;
use iSalud\ClientsManager\Domain\Client\ClientCollection;
use iSalud\ClientsManager\Infrastructure\Service\Error\GenerateCSVFileException;

final class GenerateClientsCSV implements ExportClientsToFile
{
    private const DESTINATION_PATH = '/var/www/tmp/';
    private array $headers = [
        'Name',
        'Email',
        'Phone',
        'Company'
    ];

    /**
     * @throws GenerateCSVFileException
     */
    public function execute(ClientCollection $clientCollection, ?string $destinationFileName): string
    {
        $filePath = $this->getDestinationPath($destinationFileName);

        try {
            if ($clientCollection->isEmpty()) {
                throw new \Exception('No clients data');
            }

            $filePointerResource = \fopen($filePath, 'w');
            \fputcsv($filePointerResource, $this->headers);

            /* @var Client $client */
            foreach ($clientCollection as $client) {
                \fputcsv($filePointerResource, $client->toArray());
            }

            \fclose($filePointerResource);

            return $filePath;
        } catch (\Exception $exception) {
            throw GenerateCSVFileException::create($exception->getMessage(), $filePath);
        }
    }

    private function getDestinationPath(string $destinationFileName): string
    {
        if (empty($destinationFileName)) {
            $destinationFileName = \date('Y-m-d', time()) . '_' . \uniqid() . '_clients.csv';
        }

        return self::DESTINATION_PATH . $destinationFileName;
    }

    public static function create(): self
    {
        return new self();
    }
}
