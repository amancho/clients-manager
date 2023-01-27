<?php

namespace iSalud\Tests\Unit\ClientsManager\Application\Service\ClientTransformer;

use Faker\Factory;
use Faker\Generator;
use iSalud\ClientsManager\Application\Service\ClientTransformer\ClientCollectionTransformer;
use iSalud\ClientsManager\Domain\Client\Client;
use PHPUnit\Framework\TestCase;

class ClientTransformerTest extends TestCase
{
    private Generator $faker;
    private ClientCollectionTransformer $sut;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->sut = ClientCollectionTransformer::create();
    }

    public function test_client_collection_transformer_works()
    {
        $clientCollection = $this->sut->transform([
            [
                'id' => $this->faker->numberBetween(10, 99),
                'name' => $this->faker->name(),
                'email' => $this->faker->email(),
                'phone' => $this->faker->phoneNumber(),
                'companyName' => $this->faker->company()
            ]
        ]);

        $this->assertTrue($clientCollection->isNotEmpty());
        $this->assertTrue($clientCollection->count() == 1);
        $this->assertInstanceOf(Client::class, $clientCollection->first());
    }

    public function test_client_collection_transformer_fail()
    {
        $clientCollection = $this->sut->transform([
            [
                'uuid' => $this->faker->numberBetween(10, 99),
            ]
        ]);

        $this->assertTrue($clientCollection->isEmpty());
        $this->assertTrue($clientCollection->count() == 0);
    }

}