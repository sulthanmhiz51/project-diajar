<?php

interface Middleware
{
    /**
     * Summary of handle
     * @param array $params Optional parameters
     * @return bool True if the request should proceed, false to stop 
     */
    public function handle(array $params = []): bool;
}
