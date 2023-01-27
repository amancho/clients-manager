<?php declare(strict_types=1);

namespace iSalud\Shared\Domain\Error;

use Exception;

final class InvalidCollectionItemType extends Exception
{
    public static function invalidItem(string $item, string $expectedItem): self
    {
        return new self(\sprintf('The item %s is not an instance of %s', $item, $expectedItem));
    }
}
