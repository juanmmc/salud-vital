<?php

namespace Infrastructure;

use Domain\NotificacionInterface;
use Domain\Persona;

class NotificacionEmail implements NotificacionInterface
{
    public function enviar(Persona $persona, string $mensaje): void
    {
        $email = $persona->getEmail();
        $archivo = __DIR__ . '/../../data/notificaciones_email.log';
        file_put_contents($archivo, "Para: $email | Mensaje: $mensaje" . PHP_EOL, FILE_APPEND);
    }
}
