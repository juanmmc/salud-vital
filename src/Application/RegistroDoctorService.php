<?php

namespace Application;

use Domain\Doctor;
use Domain\RepositorioDoctoresInterface;
use Domain\LogOperacionInterface;

class RegistroDoctorService
{
    private RepositorioDoctoresInterface $repoDoctores;
    private LogOperacionInterface $log;

    public function __construct(RepositorioDoctoresInterface $repoDoctores, LogOperacionInterface $log)
    {
        $this->repoDoctores = $repoDoctores;
        $this->log = $log;
    }

    public function registrar(Doctor $doctor): void
    {
        $this->repoDoctores->agregar($doctor);
        $this->log->registrar('registro_doctor', ['id' => $doctor->getId(), 'nombre' => $doctor->getNombre()]);
    }
}
