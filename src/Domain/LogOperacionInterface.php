<?php

namespace Domain;

interface LogOperacionInterface
{
    public function registrar(string $operacion, array $datos): void;
}
