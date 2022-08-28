<?php

declare(strict_types=1);

namespace PeibinLaravel\Server\Actions;

use Illuminate\Http\Request;
use Swoole\Http\Request as SwooleRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class ConvertSwooleRequestToSymfonyRequest
{
    /**
     * Convert the given Swoole request into an Illuminate request.
     * @param SwooleRequest $swooleRequest
     * @return Request
     */
    public function __invoke(SwooleRequest $swooleRequest): Request
    {
        $serverVariables = $this->prepareServerVariables(
            $swooleRequest->server ?? [],
            $swooleRequest->header ?? []
        );

        $request = new SymfonyRequest(
            $swooleRequest->get ?? [],
            $swooleRequest->post ?? [],
            [],
            $swooleRequest->cookie ?? [],
            $swooleRequest->files ?? [],
            $serverVariables,
            $swooleRequest->rawContent(),
        );

        return Request::createFromBase($request);
    }

    /**
     * Parse the "server" variables and headers into a single array of $_SERVER variables.
     * @param array $server
     * @param array $headers
     * @return array
     */
    protected function prepareServerVariables(array $server, array $headers): array
    {
        $results = [];

        foreach ($server as $key => $value) {
            $results[strtoupper($key)] = $value;
        }

        $results = array_merge(
            $results,
            $this->formatHttpHeadersIntoServerVariables($headers)
        );

        if (
            isset($results['REQUEST_URI'], $results['QUERY_STRING']) &&
            strlen($results['QUERY_STRING']) > 0 &&
            !str_contains($results['REQUEST_URI'], '?')
        ) {
            $results['REQUEST_URI'] .= '?' . $results['QUERY_STRING'];
        }

        return $results;
    }

    /**
     * Format the given HTTP headers into properly formatted $_SERVER variables.
     * @param array $headers
     * @return array
     */
    protected function formatHttpHeadersIntoServerVariables(array $headers): array
    {
        $results = [];

        foreach ($headers as $key => $value) {
            $key = strtoupper(str_replace('-', '_', $key));

            if (!in_array($key, ['HTTPS', 'REMOTE_ADDR', 'SERVER_PORT'])) {
                $key = 'HTTP_' . $key;
            }

            $results[$key] = $value;
        }

        return $results;
    }
}
