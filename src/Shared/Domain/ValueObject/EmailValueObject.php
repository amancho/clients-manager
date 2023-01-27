<?php

namespace iSalud\Shared\Domain\ValueObject;

abstract class EmailValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        if (!$this->isValid($value)) {
            $value = '';
        }

        $this->value = $value;
    }

    public function isValid(string $email): bool
    {
        return (\filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function value(): string
    {
        return $this->value;
    }
}