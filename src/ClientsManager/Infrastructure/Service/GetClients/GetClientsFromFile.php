<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GetClients;

use iSalud\ClientsManager\Application\Command\RenewClients\ImportClientsFromFile;
use iSalud\ClientsManager\Application\Service\ClientTransformer\ClientCollectionTransformer;
use iSalud\ClientsManager\Domain\Client\ClientCollection;
use iSalud\ClientsManager\Infrastructure\Service\Error\FileNotExistException;
use iSalud\ClientsManager\Infrastructure\Service\Error\InvalidXmlFileException;
use iSalud\Shared\Domain\Error\InvalidCollectionItemType;
use SimpleXMLElement;

final class GetClientsFromFile implements ImportClientsFromFile
{
    private array $mappedAttributes = [
        'clientID' => 'id'
    ];

    public function __construct(
        private readonly ClientCollectionTransformer $clientCollectionTransformer
    )
    {
    }

    /**
     * @throws InvalidXmlFileException
     * @throws FileNotExistException
     * @throws InvalidCollectionItemType
     */
    public function execute(string $filePath): ClientCollection
    {
        $xml = $this->loadFile($filePath);

        return $this->getClients($xml);
    }

    /**
     * @throws InvalidXmlFileException
     * @throws FileNotExistException
     */
    private function loadFile(string $filePath): SimpleXMLElement
    {
        if (!\file_exists($filePath) || !\is_file($filePath)) {
            throw FileNotExistException::create($filePath);
        }

        try {
            $xml = \simplexml_load_file($filePath, 'SimpleXMLIterator');
        } catch (\Exception $exception) {
            throw InvalidXmlFileException::create($filePath);
        }

        if (!$xml) {
            throw InvalidXmlFileException::create($filePath);
        }

        return $xml;
    }

    public static function create(): self
    {
        return new self(
            ClientCollectionTransformer::create()
        );
    }

    /**
     * @throws InvalidCollectionItemType
     */
    private function getClients(SimpleXMLElement $xml): ClientCollection
    {
        $xml->rewind();

        $clients = [];

        while ($xml->valid()) {
            $clients[] = $this->mapClient($xml->current());
            $xml->next();
        }

        return $this->clientCollectionTransformer->transform($clients);
    }

    private function mapClient(SimpleXMLElement $clientData): array
    {
        $client['email'] = (string)$clientData;

        foreach ($clientData->attributes() as $attributeName => $attributeValue) {
            $client[$this->mapAttribute($attributeName)] = (string)$attributeValue;
        }

        return $client;
    }

    private function mapAttribute(string $attributeName): string
    {
        if (\array_key_exists($attributeName, $this->mappedAttributes)) {
            return $this->mappedAttributes[$attributeName];
        }

        return $attributeName;
    }
}