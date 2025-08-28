<?php

namespace Domain;

use Domain\Paciente;

interface NotificacionInterface
{
    public function enviar(Paciente $paciente, string $mensaje): void;
}
