<?php

namespace Smsfire\Http;

interface Client
{
    public function request($method, $uri, ...$params): Response;
}
