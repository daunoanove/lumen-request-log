<?php

namespace MalvikLab;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LumenRequestLogMiddleware {
    protected const VERSION = '1.0.3';
    protected const REQUEST_LOG_CHANNEL = 'REQUEST_LOG_CHANNEL';

    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response, string $log = null): void
    {
        if ( is_null($log) )
        {
            $log = $this->make($request, $response);
        }

        if ( is_null(env(self::REQUEST_LOG_CHANNEL)) )
        {
            Log::info($log);
        } else {
            Log::channel(env(self::REQUEST_LOG_CHANNEL))->info($log);
        }
    }

    public function make($request, $response): string
    {
        if ( is_string($response->headers->get('Content-Type')) AND true === str_contains($response->headers->get('Content-Type'), 'text/html') )
        {
            $res = $this->removeContent($response);
        } else {
            $res = (string)$response;
        }

        return sprintf("\n>>>>>>>> REQUEST\n%s\n\n<<<<<<<< RESPONSE\n%s\n", (string)$request, $res);
    }

    protected function removeContent($obj): string
    {
        switch(true)
        {
            case $obj instanceof Request;
            case $obj instanceof Response;
                return trim(str_replace($obj->getContent(), '', (string)$obj));
                break;

            default:
                return '';
                break;
        }
    }
}