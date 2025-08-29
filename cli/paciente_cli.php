<?php
// cli/paciente_cli.php

require_once __DIR__ . '/../src/Domain/Persona.php';
require_once __DIR__ . '/../src/Domain/Paciente.php';
require_once __DIR__ . '/../src/Domain/Especialidad.php';
require_once __DIR__ . '/../src/Domain/Doctor.php';
require_once __DIR__ . '/../src/Domain/CitaMedica.php';
require_once __DIR__ . '/../src/Domain/LogOperacionInterface.php';
require_once __DIR__ . '/../src/Domain/NotificacionInterface.php';
require_once __DIR__ . '/../src/Domain/RepositorioCitasInterface.php';
require_once __DIR__ . '/../src/Infrastructure/LogOperacionArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/NotificacionEmail.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioPacientesArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioEspecialidadesArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioDoctoresArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioCitasArchivo.php';
require_once __DIR__ . '/../src/Application/NotificacionService.php';
require_once __DIR__ . '/../src/Application/RegistroPacienteService.php';
require_once __DIR__ . '/../src/Application/ReservaCitaService.php';
require_once __DIR__ . '/../src/Application/CancelacionCitaService.php';
require_once __DIR__ . '/../src/Application/ReprogramacionCitaService.php';

use Domain\Paciente;
use Domain\CitaMedica;
use Infrastructure\LogOperacionArchivo;
use Infrastructure\NotificacionEmail;
use Infrastructure\RepositorioPacientesArchivo;
use Infrastructure\RepositorioEspecialidadesArchivo;
use Infrastructure\RepositorioDoctoresArchivo;
use Infrastructure\RepositorioCitasArchivo;
use Application\NotificacionService;
use Application\RegistroPacienteService;
use Application\ReservaCitaService;
use Application\CancelacionCitaService;
use Application\ReprogramacionCitaService;

$accion = $argv[1] ?? null;

if (!$accion || !in_array($accion, ['registrar', 'actualizar', 'reservar', 'cancelar', 'reprogramar'])) {
    echo "Uso: php paciente_cli.php [registrar|actualizar|reservar|cancelar|reprogramar]\n";
    exit(1);
}

function leer($mensaje) {
    echo $mensaje;
    return trim(fgets(STDIN));
}

// Registrar o actualizar paciente
if ($accion === 'registrar' || $accion === 'actualizar') {
    $id = leer('ID: ');
    $nombre = leer('Nombre: ');
    $apellido = leer('Apellido: ');
    $dni = leer('DNI: ');
    $telefono = leer('Teléfono: ');
    $email = leer('Email: ');

    $repoPacientes = new RepositorioPacientesArchivo(__DIR__ . '/../data/pacientes.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    
    $servicio = new RegistroPacienteService($repoPacientes, $log);

    $paciente = new Paciente($id, $nombre, $apellido, $dni, $telefono, $email);

    if ($accion === 'registrar') {
        $servicio->registrar($paciente);
        echo "Paciente registrado correctamente.\n";
    } else {
        $servicio->actualizar($paciente);
        echo "Paciente actualizado correctamente.\n";
    }
}

// Reservar cita
if ($accion === 'reservar') {
    $idCitaMedica = leer('ID Cita Médica: ');
    $fecha = leer('Fecha (YYYY-MM-DD): ');
    $hora = leer('Hora (HH:MM): ');
    $idPaciente = leer('ID Paciente: ');
    $idEspecialidad = leer('ID Especialidad: ');
    $idDoctor = leer('ID Doctor: ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $repoPacientes = new RepositorioPacientesArchivo(__DIR__ . '/../data/pacientes.json');
    $repoEspecialidades = new RepositorioEspecialidadesArchivo(__DIR__ . '/../data/especialidades.json');
    $repoDoctores = new RepositorioDoctoresArchivo(__DIR__ . '/../data/doctores.json');
    
    $paciente = $repoPacientes->obtenerPorId($idPaciente);
    $especialidad = $repoEspecialidades->obtenerPorId($idEspecialidad);
    $doctor = $repoDoctores->obtenerPorId($idDoctor);
    
    $citaMedica = new CitaMedica($idCitaMedica, $fecha, $hora, $paciente, $especialidad, $doctor);

    $servicio = new ReservaCitaService($repoCitas, $log, $notificacionService);
    $servicio->reservar($citaMedica);
    echo "Reserva de cita médica exitosa.\n";
}

// Cancelar cita
if ($accion === 'cancelar') {
    $idCita = leer('ID Cita: ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $repoPacientes = new RepositorioPacientesArchivo(__DIR__ . '/../data/pacientes.json');

    $cita = $repoCitas->obtenerPorId($idCita);
    if (!$cita) {
        echo "Cita no encontrada.\n";
        exit(1);
    }
    $paciente = $repoPacientes->obtenerPorId($cita->getPaciente()->getId());
    $cita->setPaciente($paciente);

    $servicio = new CancelacionCitaService($repoCitas, $log, $notificacionService);
    $servicio->cancelar($cita);
    echo "Cancelación de cita médica exitosa.\n";
}

// Reprogramar cita
if ($accion === 'reprogramar') {
    $idCita = leer('ID Cita: ');
    $nuevaFecha = leer('Nueva fecha (YYYY-MM-DD): ');
    $nuevaHora = leer('Nueva hora (HH:MM): ');

    $repoCitas = new RepositorioCitasArchivo(__DIR__ . '/../data/citas.json');
    $log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
    $notificacionService = new NotificacionService([
        new NotificacionEmail()
    ]);
    $repoPacientes = new RepositorioPacientesArchivo(__DIR__ . '/../data/pacientes.json');

    $cita = $repoCitas->obtenerPorId($idCita);
    if (!$cita) {
        echo "Cita no encontrada.\n";
        exit(1);
    }

    $cita->setFecha($nuevaFecha);
    $cita->setHora($nuevaHora);

    $paciente = $repoPacientes->obtenerPorId($cita->getPaciente()->getId());
    $cita->setPaciente($paciente);

    $servicio = new ReprogramacionCitaService($repoCitas, $log, $notificacionService);
    $servicio->reprogramar($cita);

    echo "Reprogramación de cita médica exitosa.\n";
}
