# Salud Vital
Primer trabajo del diplomado en microservicios en la NUR, modulo 1

## Indicaciones para uso y verificación de los requerimientos

Comando de ejecución única para insertar datos de especialidades y doctores

```
php cli/seed_cli.php

```

Comando para registrar, actualizar pacientes y reservar, cancelar y reprogramar citas médicas

```
php cli/paciente_cli.php [registrar|actualizar|reservar|cancelar|reprogramar]

```

Comando para consultar agenda diaria, aprobar/rechazar y registrar resumen en citas médicas

```
php cli/doctor_cli.php [agenda|aprobar|rechazar|resumen]

```

## Principios SOLID aplicados

1. **Single Responsibility Principle (SRP)**:  
   Cada clase tiene una única responsabilidad. Por ejemplo:
   - `AgendaDoctorService` se encarga exclusivamente de obtener la agenda de un doctor.
   - `RegistroPacienteService` se encarga de registrar y actualizar pacientes.
   - `RepositorioCitasArchivo` maneja exclusivamente el almacenamiento y recuperación de citas médicas.

2. **Open/Closed Principle (OCP)**:  
   Las clases están abiertas para extensión pero cerradas para modificación. Por ejemplo:
   - La interfaz `NotificacionInterface` permite agregar nuevos tipos de notificaciones (como `NotificacionEmail` y `NotificacionSMS`) sin modificar las clases existentes.

3. **Liskov Substitution Principle (LSP)**:  
   Las clases derivadas pueden sustituir a sus clases base sin alterar el comportamiento esperado. Por ejemplo:
   - `Paciente` y `Doctor` extienden de `Persona` y pueden ser usadas donde se espera una `Persona`.

4. **Interface Segregation Principle (ISP)**:  
   Las interfaces están diseñadas para cumplir con responsabilidades específicas. Por ejemplo:
   - `RepositorioCitasInterface`, `RepositorioPacientesInterface`, y `RepositorioDoctoresInterface` están separadas para manejar sus respectivas entidades.

5. **Dependency Inversion Principle (DIP)**:  
   Las clases de alto nivel dependen de abstracciones en lugar de implementaciones concretas. Por ejemplo:
   - Los servicios como `AprobacionCitaService` dependen de interfaces (`RepositorioCitasInterface`, `RepositorioDoctoresInterface`) en lugar de implementaciones concretas.

## Repositorio del proyecto

El código fuente de este proyecto está disponible en GitHub: [Salud Vital](https://github.com/juanmmc/salud-vital)