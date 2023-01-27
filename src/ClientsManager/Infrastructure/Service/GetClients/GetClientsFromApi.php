<?php

namespace iSalud\ClientsManager\Infrastructure\Service\GetClients;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use iSalud\ClientsManager\Application\Command\RenewClients\ImportClientsFromApi;
use iSalud\ClientsManager\Application\Service\ClientTransformer\ClientCollectionTransformer;
use iSalud\ClientsManager\Domain\Client\ClientCollection;
use iSalud\Shared\Domain\Error\InvalidCollectionItemType;
use JsonException;

final class GetClientsFromApi implements ImportClientsFromApi
{
    private const USERS_ENDPOINT = 'https://jsonplaceholder.typicode.com/users';
    private const HTTP_STATUS_CODE_200 = 200;

    public function __construct(
        private readonly Client                      $guzzleClient,
        private readonly ClientCollectionTransformer $clientCollectionTransformer
    )
    {
    }

    public static function create(): self
    {
        return new self(
            new Client(),
            ClientCollectionTransformer::create()
        );
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function execute(): ClientCollection
    {
        $response = $this->guzzleClient->request('GET', self::USERS_ENDPOINT);

        if ($response->getStatusCode() !== self::HTTP_STATUS_CODE_200) {
            throw new \Exception ('ERROR:: Incorrect API response with code ' . $response->getStatusCode());
        }

        return $this->parseResponse($response->getBody()->getContents());
    }

    /**
     * @throws JsonException
     * @throws InvalidCollectionItemType
     */
    private function parseResponse(string $response): ClientCollection
    {
        return $this->clientCollectionTransformer->transform($this->decodeResponse($response));
    }

    /**
     * @throws JsonException
     */
    private function decodeResponse(string $response): array
    {
        $clients = \json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!\is_array($clients)) {
            throw new JsonException('Decoded data must be array');
        }

        $parsedUsers = [];

        foreach ($clients as $client) {
            $client['company'] = $client['company']['name'] ?? '';
            $parsedUsers[] = $client;
        }

        return $parsedUsers;
    }
}