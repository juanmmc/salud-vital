<?php
// cli/doctor_cli.php

require_once __DIR__ . '/cli_utils.php';
require_once __DIR__ . '/../src/Domain/Persona.php';
require_once __DIR__ . '/../src/Domain/Paciente.php';
require_once __DIR__ . '/../src/Domain/Especialidad.php';
require_once __DIR__ . '/../src/Domain/Doctor.php';
require_once __DIR__ . '/../src/Domain/CitaMedica.php';
require_once __DIR__ . '/../src/Domain/RepositorioCitasInterface.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioCitasArchivo.php';
require_once __DIR__ . '/../src/Application/AgendaDoctorService.php';

use Infrastructure\RepositorioCitasArchivo;
use Application\AgendaDoctorService;

$accion = $argv[1] ?? null;

if (!$accion || !in_array($accion, ['agenda', 'aprobar', 'rechazar', 'resumen'])) {
    echo "Uso: php doctor_cli.php [agenda|aprobar|rechazar|resumen]\n";
    exit(1);
}

// Lógica para consultar la agenda diaria
if ($accion === 'agenda') {
    $idDoctor = leer('ID Doctor: ');
    $fecha = leer('Fecha (YYYY-MM-DD): ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');

    $servicio = new AgendaDoctorService($repoCitas);
    $citas = $servicio->obtenerAgenda($idDoctor, $fecha);
    mostrarCitas($citas);
}

// Lógica para aprobar una cita médica
if ($accion === 'aprobar') {
}

// Lógica para rechazar una cita médica
if ($accion === 'rechazar') {
}

// Lógica para registrar un resumen de consulta
if ($accion === 'resumen') {
}