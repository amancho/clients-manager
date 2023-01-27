<?php declare(strict_types=1);

namespace iSalud\ClientsManager\Infrastructure\Service\Error;

use Exception;

final class InvalidXmlFileException extends Exception
{
    public static function create(string $filePath): self
    {
        return new self(\sprintf('The file %s is not a valid XML', $filePath));
    }
}
