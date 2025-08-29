<?php

namespace Application;

use Domain\Especialidad;
use Domain\RepositorioEspecialidadesInterface;
use Domain\LogOperacionInterface;

class RegistroEspecialidadService
{
    private RepositorioEspecialidadesInterface $repoEspecialidades;
    private LogOperacionInterface $log;

    public function __construct(RepositorioEspecialidadesInterface $repoEspecialidades, LogOperacionInterface $log)
    {
        $this->repoEspecialidades = $repoEspecialidades;
        $this->log = $log;
    }

    public function registrar(Especialidad $especialidad): void
    {
        $this->repoEspecialidades->agregar($especialidad);
        $this->log->registrar('registro_especialidad', ['id' => $especialidad->getId(), 'nombre' => $especialidad->getNombre()]);
    }
}
