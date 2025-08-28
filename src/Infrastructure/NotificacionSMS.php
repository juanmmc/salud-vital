<?php

namespace Infrastructure;

use Domain\NotificacionInterface;
use Domain\Persona;

class NotificacionSMS implements NotificacionInterface
{
    public function enviar(Persona $persona, string $mensaje): void
    {
        $telefono = $persona->getTelefono();

        $archivo = __DIR__ . '/../../data/notificaciones_sms.log';
        file_put_contents($archivo, "Para: $telefono | Mensaje: $mensaje" . PHP_EOL, FILE_APPEND);
    }
}
