<?php

namespace Infrastructure;

use Domain\LogOperacionInterface;

class LogOperacionArchivo implements LogOperacionInterface
{
    private string $archivo;

    public function __construct(string $archivo)
    {
        $this->archivo = $archivo;
    }

    public function registrar(string $operacion, array $datos): void
    {
        $registro = [
            'fecha' => date('Y-m-d H:i:s'),
            'operacion' => $operacion,
            'datos' => $datos
        ];
        file_put_contents(
            $this->archivo,
            json_encode($registro) . PHP_EOL,
            FILE_APPEND
        );
    }
}
