<?php

namespace iSalud\Tests\Integration\ClientsManager\Infrastructure\Service\GetClients;

use GuzzleHttp\Psr7\Response;
use iSalud\ClientsManager\Application\Service\ClientTransformer\ClientCollectionTransformer;
use iSalud\ClientsManager\Infrastructure\Service\GetClients\GetClientsFromApi;
use iSalud\Tests\TestDoubles\Vendors\Guzzle\FakeGuzzleClient;
use PHPUnit\Framework\TestCase;

class GetClientsFromApiTest extends TestCase
{
    private const HTTP_CODE_SUCCESS = 200;
    private GetClientsFromApi $sut;

    public function test_it_get_clients_from_api_works(): void
    {
        $apiResponse = $this->getApiResponse();

        $this->client->setRequestReturnValue(
            $this->getResponse(self::HTTP_CODE_SUCCESS, \json_encode($apiResponse))
        );

        $clientCollection = $this->sut->execute();

        $this->assertTrue($clientCollection->isNotEmpty());
        $this->assertEquals(count($apiResponse), $clientCollection->count());
    }

    private function getApiResponse(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Leanne Graham',
                'email' => 'Sincere@april.biz',
                'phone' => '1-770-736-8031 x56442',
                'company' => [
                    'name' => 'Romaguera-Crona'
                ]
            ]
        ];
    }

    private function getResponse(int $httpStatusCode = 200, string $body = ''): Response
    {
        return new Response($httpStatusCode, [], $body);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new FakeGuzzleClient();
        $this->sut = new GetClientsFromApi($this->client, ClientCollectionTransformer::create());
    }
}