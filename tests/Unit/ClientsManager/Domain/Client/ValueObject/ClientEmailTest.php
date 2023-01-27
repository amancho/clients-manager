<?php

namespace iSalud\Tests\Unit\ClientsManager\Domain\Client\ValueObject;

use Faker\Factory;
use Faker\Generator;
use iSalud\ClientsManager\Domain\Client\ValueObject\ClientEmail;
use PHPUnit\Framework\TestCase;

final class ClientEmailTest extends TestCase
{
    private Generator $faker;

    public function test_email_is_valid()
    {
        $email = $this->faker->email();

        $clientEmail = new ClientEmail($email);
        $this->assertInstanceOf(ClientEmail::class, $clientEmail);

        $this->assertTrue($clientEmail->isValid($email));
        $this->assertEquals($email, $clientEmail->value());
    }

    public function test_email_is_not_valid()
    {
        $email = $this->faker->company();

        $clientEmail = new ClientEmail($email);
        $this->assertInstanceOf(ClientEmail::class, $clientEmail);

        $this->assertFalse($clientEmail->isValid($email));
        $this->assertEmpty($clientEmail->value());
    }

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }
}