<?php

namespace Smsfire\Http;

interface Client
{
    public function request(string $method, string $uri, array ...$params): Response;
}
