<?php
// cli/doctor_cli.php

require_once __DIR__ . '/cli_utils.php';
require_once __DIR__ . '/../src/Domain/Persona.php';
require_once __DIR__ . '/../src/Domain/Paciente.php';
require_once __DIR__ . '/../src/Domain/Especialidad.php';
require_once __DIR__ . '/../src/Domain/Doctor.php';
require_once __DIR__ . '/../src/Domain/CitaMedica.php';
require_once __DIR__ . '/../src/Domain/LogOperacionInterface.php';
require_once __DIR__ . '/../src/Domain/RepositorioCitasInterface.php';
require_once __DIR__ . '/../src/Domain/RepositorioPacientesInterface.php';
require_once __DIR__ . '/../src/Domain/RepositorioEspecialidadesInterface.php';
require_once __DIR__ . '/../src/Domain/RepositorioDoctoresInterface.php';
require_once __DIR__ . '/../src/Domain/NotificacionInterface.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioCitasArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioDoctoresArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/LogOperacionArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/NotificacionEmail.php';
require_once __DIR__ . '/../src/Application/AgendaDoctorService.php';
require_once __DIR__ . '/../src/Application/AprobacionCitaService.php';
require_once __DIR__ . '/../src/Application/ResumenCitaService.php';
require_once __DIR__ . '/../src/Application/NotificacionService.php';

use Infrastructure\RepositorioCitasArchivo;
use Infrastructure\RepositorioDoctoresArchivo;
use Infrastructure\LogOperacionArchivo;
use Infrastructure\NotificacionEmail;
use Application\AgendaDoctorService;
use Application\AprobacionCitaService;
use Application\ResumenCitaService;
use Application\NotificacionService;

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
    $idCita = leer('ID Cita: ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $repoDoctores = new RepositorioDoctoresArchivo(__DIR__ . '/../data/doctores.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $servicio = new AprobacionCitaService($repoCitas, $repoDoctores, $log, $notificacionService);
    $servicio->aprobar($idCita);
    echo "Aprobación de cita médica exitosa.\n";
}

// Lógica para rechazar una cita médica
if ($accion === 'rechazar') {
    $idCita = leer('ID Cita: ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $repoDoctores = new RepositorioDoctoresArchivo(__DIR__ . '/../data/doctores.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $servicio = new AprobacionCitaService($repoCitas, $repoDoctores, $log, $notificacionService);
    $servicio->rechazar($idCita);
    echo "Rechazo de cita médica exitosa.\n";
}

// Lógica para registrar un resumen de consulta
if ($accion === 'resumen') {
    $idCita = leer('ID Cita: ');
    $resumen = leer('Resumen: ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $repoDoctores = new RepositorioDoctoresArchivo(__DIR__ . '/../data/doctores.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $servicio = new ResumenCitaService($repoCitas, $repoDoctores, $log, $notificacionService);
    $servicio->registrar($idCita, $resumen);
    echo "Registro de resumen de cita médica exitosa.\n";
}