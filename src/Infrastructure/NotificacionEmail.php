<?php

namespace Infrastructure;

use Domain\NotificacionInterface;
use Domain\Paciente;

class NotificacionEmail implements NotificacionInterface
{
    public function enviar(Paciente $paciente, string $mensaje): void
    {
        $email = $paciente->getEmail();
        file_put_contents('notificaciones_email.log', "Para: $email | Mensaje: $mensaje" . PHP_EOL, FILE_APPEND);
    }
}
