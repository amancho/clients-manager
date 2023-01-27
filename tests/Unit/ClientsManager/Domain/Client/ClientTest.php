<?php

namespace iSalud\Tests\Unit\ClientsManager\Domain\Client;

use Faker\Factory;
use Faker\Generator;
use iSalud\ClientsManager\Domain\Client\Client;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientCompanyName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientEmail;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientId;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientName;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientPhone;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{

    private Generator $faker;

    public function test_user_works()
    {
        $clientId = (string)$this->faker->numberBetween(10, 99);
        $clientName = $this->faker->userName();
        $clientEmail = $this->faker->email();
        $clientPhone = $this->faker->phoneNumber();
        $companyName = $this->faker->company();

        $client = Client::create(
            new ClientId($clientId),
            new ClientName($clientName),
            new ClientEmail($clientEmail),
            new ClientPhone($clientPhone),
            new ClientCompanyName($companyName)
        );

        $this->assertInstanceOf(Client::class, $client);
        $this->assertIsString($client->id()->value());
        $this->assertIsString($client->name()->value());
        $this->assertIsString($client->email()->value());
        $this->assertIsString($client->phone()->value());
        $this->assertIsString($client->companyName()->value());

        $this->assertEquals($clientId, $client->id()->value(),);
        $this->assertEquals($clientName, $client->name()->value(),);
        $this->assertEquals($clientEmail, $client->email()->value());
        $this->assertEquals($clientPhone, $client->phone()->value());
        $this->assertEquals($companyName, $client->companyName()->value());
    }

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }
}