<?php declare(strict_types=1);

namespace iSalud\Shared\Domain;

use ArrayIterator;
use Countable;
use iSalud\Shared\Domain\Error\InvalidCollectionItemType;
use IteratorAggregate;

abstract class Collection implements Countable, IteratorAggregate
{
    protected array $items;

    /**
     * @param mixed ...$items
     *
     * @throws InvalidCollectionItemType
     */
    public function __construct(...$items)
    {
        $this->validateArray($this->type(), $items);

        $this->items = $items;
    }

    /** @throws InvalidCollectionItemType */
    protected function validateArray(string $type, array $items): void
    {
        foreach ($items as $item) {
            $this->validateItem($type, $item);
        }
    }

    /** @throws InvalidCollectionItemType */
    protected function validateItem(string $type, $item): void
    {
        if (!$item instanceof $type) {
            $this->throwExceptionForInvalidItems($item::class);
        }
    }

    /** @throws InvalidCollectionItemType */
    protected function throwExceptionForInvalidItems(string $invalidType): void
    {
        throw InvalidCollectionItemType::invalidItem($invalidType, $this->type());
    }

    abstract protected function type(): string;

    public function getIterator(): \ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function items(): array
    {
        return $this->items;
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return \count($this->items());
    }

    /** @param object $itemToCompare */
    public function contains(mixed $itemToCompare): bool
    {
        foreach ($this->items() as $item) {
            if (\method_exists($item, 'equals')) {
                if (!$item->equals($itemToCompare)) {
                    continue;
                }

                return true;
            }

            if (\method_exists($item, 'equalsTo')) {
                if (!$item->equalsTo($itemToCompare)) {
                    continue;
                }

                return true;
            }

            if ($itemToCompare != $item) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function equals(Collection $otherCollection): bool
    {
        return $this == $otherCollection;
    }

    public function each(callable $fn): void
    {
        foreach ($this->items() as $key => $item) {
            $fn($item, $key);
        }
    }

    public function filter(callable $fn): array
    {
        return \array_filter(\array_values($this->items()), $fn);
    }

    public function first(): mixed
    {
        $keys = \array_keys($this->items);

        if ([] === $keys) {
            return null;
        }

        return $this->items[$keys[0]];
    }

    public function forget(int $key): void
    {
        if (\array_key_exists($key, $this->items)) {
            unset($this->items[$key]);
        }
    }

    public function any(callable $fn): bool
    {
        foreach ($this->items() as $item) {
            $found = $fn($item);

            if ($found) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        if (!\method_exists($this->type(), 'toArray')) {
            return $this->items;
        }

        return $this->map(
            static fn($item) => $item->toArray()
        );
    }

    public function map(callable $fn): array
    {
        return \array_map($fn, \array_values($this->items()));
    }
}
