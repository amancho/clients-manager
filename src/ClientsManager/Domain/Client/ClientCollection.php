<?php

namespace iSalud\ClientsManager\Domain\Client;

use iSalud\Shared\Domain\Collection;

final class ClientCollection extends Collection
{
    public function add(Client ...$clients): void
    {
        foreach ($clients as $client) {
            $this->items[] = $client;
        }
    }

    protected function type(): string
    {
        return Client::class;
    }
}