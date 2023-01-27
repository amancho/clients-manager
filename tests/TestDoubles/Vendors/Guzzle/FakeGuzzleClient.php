<?php declare(strict_types=1);

namespace iSalud\Tests\TestDoubles\Vendors\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class FakeGuzzleClient extends Client
{
    private ResponseInterface $defaultReturnValue;
    private array $requestReturnValues;
    private $requestException;
    private array $timesCalled;

    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        if ($this->requestException !== null) {
            throw $this->requestException;
        }

        $this->incrementTimesCalledRequest($uri);

        return $this->getResponse($uri);
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        if ($this->requestException !== null) {
            throw $this->requestException;
        }

        $this->incrementTimesCalledRequest((string) $request->getUri());

        return $this->getResponse($request->getUri());
    }

    public function setRequestReturnValue(ResponseInterface $requestReturnValue): void
    {
        $this->defaultReturnValue = $requestReturnValue;
    }

    public function setResponseForURL(string $requestUri, ResponseInterface $requestReturnValue): void
    {
        $this->requestReturnValues[$requestUri] = $requestReturnValue;
    }

    public function setRequestException(\Exception $requestException): void
    {
        $this->requestException = $requestException;
    }

    public function getTimesCalledUri(string $uri): int
    {
        return $this->timesCalled[$uri] ?? 0;
    }

    public function getAllTimesCalled(): array
    {
        return $this->timesCalled;
    }

    private function getResponse($uri): ResponseInterface
    {
        if ($uri instanceof UriInterface) {
            $uri = (string) $uri;
        }
        if (!empty($this->requestReturnValues) && \array_key_exists($uri, $this->requestReturnValues)) {
            return $this->requestReturnValues[$uri];
        }

        return $this->defaultReturnValue ?? new Response();
    }

    private function incrementTimesCalledRequest(string $uri): void
    {
        if (!isset($this->timesCalled[$uri])) {
            $this->timesCalled[$uri] = 0;
        }
        $this->timesCalled[$uri]++;
    }
}
