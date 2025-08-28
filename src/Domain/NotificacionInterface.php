<?php

namespace Domain;

use Domain\Persona;

interface NotificacionInterface
{
    public function enviar(Persona $persona, string $mensaje): void;
}
