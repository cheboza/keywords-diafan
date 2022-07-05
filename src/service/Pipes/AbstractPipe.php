<?php

namespace Diafanfh\Keywords\Pipes;

use Closure;

abstract class AbstractPipe
{

    /**
     * @param array|callable $wordHandle
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(callable $wordHandle, Closure $next)
    {
        return $wordHandle([$this, 'switching']) ?? $next($wordHandle);
    }

    abstract public function switching(string $wordHandle):?string;
}
