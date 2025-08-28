<?php

namespace Application;

use Domain\NotificacionInterface;
use Domain\Paciente;

class NotificacionService
{
    /** @var NotificacionInterface[] */
    private array $notificadores;

    public function __construct(array $notificadores)
    {
        $this->notificadores = $notificadores;
    }

    public function notificar(Paciente $paciente, string $mensaje): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->enviar($paciente, $mensaje);
        }
    }
}
