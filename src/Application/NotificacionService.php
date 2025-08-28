<?php

namespace Application;

use Domain\NotificacionInterface;
use Domain\Persona;

class NotificacionService
{
    /** @var NotificacionInterface[] */
    private array $notificadores;

    public function __construct(array $notificadores)
    {
        $this->notificadores = $notificadores;
    }

    public function notificar(Persona $persona, string $mensaje): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->enviar($persona, $mensaje);
        }
    }
}
