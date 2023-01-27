<?php

namespace iSalud\Tests\Integration\ClientsManager\Infrastructure\Service\GetClients;

use iSalud\ClientsManager\Application\Service\ClientTransformer\ClientCollectionTransformer;
use iSalud\ClientsManager\Infrastructure\Service\Error\FileNotExistException;
use iSalud\ClientsManager\Infrastructure\Service\Error\InvalidXmlFileException;
use iSalud\ClientsManager\Infrastructure\Service\GetClients\GetClientsFromFile;
use PHPUnit\Framework\TestCase;

class GetClientsFromFileTest extends TestCase
{
    private const TEST_PATH = '/var/www/tests/Integration/ClientsManager/Infrastructure/Service/GetClients/';
    private GetClientsFromFile $sut;

    public function test_it_get_clients_from_file_works(): void
    {
        $clientsCollection = $this->sut->execute(self::TEST_PATH . 'data.xml');

        $this->assertTrue($clientsCollection->isNotEmpty());
        $this->assertEquals(20, $clientsCollection->count());
    }

    public function test_it_get_clients_from_file_throws_file_not_exist(): void
    {
        $this->expectException(FileNotExistException::class);
        $this->sut->execute('data.xml');
    }

    public function test_it_get_clients_from_file_throws_invalid_xml_file(): void
    {
        $this->expectException(InvalidXmlFileException::class);
        $this->sut->execute(self::TEST_PATH . 'dataInvalid.xml');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = new GetClientsFromFile(ClientCollectionTransformer::create());
    }
}