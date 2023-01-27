<?php declare(strict_types=1);

namespace iSalud\ClientsManager\Infrastructure\Service\Error;

use Exception;

final class FileNotExistException extends Exception
{
    public static function create(string $filePath): self
    {
        return new self(\sprintf('The path %s not contain a file or is incorrect', $filePath));
    }
}
