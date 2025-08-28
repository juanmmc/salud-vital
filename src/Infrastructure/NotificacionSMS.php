<?php

namespace Infrastructure;

use Domain\NotificacionInterface;
use Domain\Paciente;

class NotificacionSMS implements NotificacionInterface
{
    public function enviar(Paciente $paciente, string $mensaje): void
    {
        $telefono = $paciente->getTelefono();
        file_put_contents('notificaciones_sms.log', "Para: $telefono | Mensaje: $mensaje" . PHP_EOL, FILE_APPEND);
    }
}
