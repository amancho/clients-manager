<?php declare(strict_types=1);

namespace iSalud\ClientsManager\Infrastructure\Service\Error;

use Exception;

final class GenerateCSVFileException extends Exception
{
    public static function create(string $message, string $filePath): self
    {
        return new self(\sprintf('Error %s generating file %s', $message, $filePath));
    }
}
