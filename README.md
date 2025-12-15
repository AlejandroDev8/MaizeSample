# Sistema de inventariado para la recolección de muestras de maíz

Este proyecto es un sistema de inventariado diseñado para gestionar y rastrear la recolección de muestras de maíz. Proporciona una interfaz fácil de usar para registrar, almacenar y consultar información sobre las muestras recolectadas.

## Tabla de contenidos

- [Características](#características)
- [Tecnologías principales](#tecnologías-principales)
- [Requisitos](#requisitos)
- [Instalación y ejecución con Docker (recomendado)](#instalación-y-ejecución-con-docker-recomendado)
  - [Credenciales iniciales (Seeder)](#credenciales-iniciales-seeder)
- [Modo desarrollo (hot reload con Vite)](#modo-desarrollo-hot-reload-con-vite)
  - [Detener modo desarrollo](#detener-modo-desarrollo)
- [Comandos útiles](#comandos-útiles)
  - [Ver logs](#ver-logs)
  - [Detener contenedores](#detener-contenedores)
  - [Reiniciar desde cero (borra DB y datos)](#reiniciar-desde-cero-borra-db-y-datos)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Uso del sistema](#uso-del-sistema)
  - [Uso como Administrador](#uso-como-administrador)
  - [Uso como Recolector](#uso-como-recolector)
- [Notas sobre Sail](#notas-sobre-sail)
- [Autor](#autor)

---

## Características

1. **Control de usuarios**
   - Registro y autenticación de usuarios.
   - Roles de usuario: **Administrador** y **Recolector**.

2. **Gestión de muestras**
   - Registro de nuevas muestras con detalles como ubicación, fecha y tipo de maíz.
   - Edición y eliminación de muestras.
   - Asociación de muestras a agricultores y zonas geográficas.

3. **Catálogos geográficos (INEGI)**
   - Importación de catálogos de **Estados**, **Ciudades/Municipios** y **Localidades** desde INEGI.
   - Uso de estos catálogos para normalizar la información geográfica de las muestras.

4. **Búsqueda y filtrado**
   - Búsqueda avanzada de muestras por diferentes criterios.
   - Listados filtrables desde el panel de administración.

---

## Tecnologías principales

- [PHP](https://www.php.net/) 8.3+
- [Laravel](https://laravel.com/) 12.x
- [FilamentPHP](https://filamentphp.com/) 4.x
- [PostgreSQL](https://www.postgresql.org/) 17+ (en Docker se usa `postgres:18-alpine`)
- [Node.js](https://nodejs.org/) 20+ (en Docker dev se usa `node:20-alpine`)
- [NPM](https://www.npmjs.com/)
- [Vite](https://vitejs.dev/) (para assets de frontend)

> [!TIP] Las versiones indicadas son las utilizadas durante el desarrollo. Versiones superiores compatibles deberían funcionar sin problema.

---

## Requisitos

Antes de comenzar, asegúrate de tener instalado:

- **Docker Desktop** (Windows / macOS) o Docker Engine (Linux).
- **Docker Compose V2** (se usa como `docker compose`, no `docker-compose`).

Puertos disponibles:

- `80` para la aplicación (Laravel).
- `5432` para PostgreSQL (puedes cambiarlo en el `.env` si es necesario).
- `5173` para Vite (solo en modo desarrollo / hot reload).

Verifica que `Docker` esté listo:

```bash
docker --version
docker compose version
```

## Instalación y ejecución con Docker (recomendado)

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/AlejandroDev8/MaizeSample.git
   cd MaizeSample
   ```

2. Levanatar el proyecto

   Este comando construye la imagen, levanta PostgreSQL, ejecuta:

   - `php artisan key:generate`
   - `php artisan migrate`
   - `php artisan db:seed`
   - `php artisan inegi:import --fresh`
   - `php artisan storage:link`

    ```bash
    docker compose up -d --build
    ```

3. Abrir la aplicación en el navegador

   ```arduino
   http://localhost
   ```

### Credenciales iniciales (Seeder)

El seeder crea un usuario Administrador de ejemplo:

- **Email:** `test@example.com`
- **Password:** `password`
- **Rol:** `Administrador`

> [!WARNING] Si corres `db:seed` más de una vez sin reinciar la base de datos, puedes tener error por email duplicado (por el ínidice único en `user.email`). Si te pasa usa el "Reiniciar desde cero".

## Modo desarrollo (hot reload con Vite)

Si vas a desarrollar y quieres ver cambios al instante (hot reload), usa el compose de desarrollo:

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

- **Aplicación:** `http://localhost`
- **Vite (hot reload):** `http://localhost:5173`

### Detener modo desarrollo

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml down --remove-orphans
```

> [!WARNING] Si cambiaste dependencias (PHP/JS), puedes bajar y levantar o reinstalar con los servicios `composer`/`npm` incluidos en el compose dev.

## Comandos útiles

### Ver logs

```bash
docker compose logs -f app
```

## Detener contenedores

```bash
docker compose down
```

## Reiniciar desde cero (borra DB y datos)

Si quieres “reset total” (incluye volumen de Postgres):

```bash
docker compose down -v --remove-orphans
docker compose up -d --build
```

## Estructura del proyecto

Algunas rutas relevantes en el proyecto:

- `app/Models`
  Modelos de Eloquent para las entidades del sistema (usuarios, agricultores, muestras de maíz, etc.).
- `app/Console/Commands/ImportInegiCatalog.php`
  Comando personalizado para importar los catálogos de INEGI.
- `app/Filament/Clusters`
  Clústers de Filament para organizar recursos, por ejemplo:

  - Clúster de **Geografía** (Estados, Ciudades, Localidades).
  - Clúster de **Usuarios** (Agricultores, Recolectores).

- `app/Filament/Dashboard/Resources`
  Recursos relacionados con el panel principal de Dashboard.
- `app/Filament/Resources`
  Recursos de Filament para gestionar las muestras de maíz, etc en el panel de Administrador.
- `app/Providers/`
  Proveedores de servicios de la aplicación.
- `database/migrations`
  Migraciones de la base de datos.
- `database/seeders`
  Seeders para poblar la base de datos con datos iniciales (roles, usuario administrador, etc.).

## Uso del sistema

## Uso como Administrador

1. Accede a la aplicación en tu navegador:

   ```arduino
   http://localhost
   ```

2. Inicia sesión con la cuenta de `Administrador` creada por los seeders (consulta `database/seeders` para ver las credenciales configuradas).
3. Al iniciar sesión, serás dirigido al panel de `Dashboard`. Desde allí tienes un botón en la parte superior derecha para acceder al panel de `Administrador`.
4. En el panel de `Administrador` puedes:
   - Gestionar los clústeres de Usuarios (Usuarios, Agricultores, etc.).
   - Gestionar los clústeres de Geografía (Estados, Ciudades/Municipios, Localidades).
   - Gestionar las muestras de maíz.
5. Para crear un nuevo usuario:
   - Ve a la sección de `Usuarios`.
   - Haz clic en `Usuarios` y luego en `Crear Usuario`.
   - Llena el formulario con los datos del nuevo usuario y asigna el rol correspondiente (Administrador o Recolector).
6. Para gestionar la geografía:
   - Ve a la sección de `Geografía`.
   - Podrás visualizar y gestionar `Estados, Ciudades/Municipios y Localidades`.
7. Para crear un registro de Agricultor:
   - Ve a la sección de `Usuarios`.
   - Haz clic en `Agricultores` y luego en `Crear Agricultor`.
8. Para ver las muestras de maíz recolectadas:
   - Ve a la sección de `Muestras de Maíz`.
   - Ahí encontrarás un listado con todas las muestras e información relevante.
   - Haz clic en un registro para ver el detalle completo de la muestra.

## Uso como Recolector

1. Accede a la aplicación en tu navegador:

   ```arduino
   http://localhost
   ```

2. Inicia sesión con tu cuenta de `Recolector` (creada previamente por el administrador).
3. Serás redirigido al panel de `Dashboard` y desde ahí directamente a la sección de Muestras de Maíz.
4. Para registrar una nueva muestra:
   - Haz clic en `Crear Muestra de Maíz`.
   - Completa el formulario con los detalles de la muestra (ubicación, fecha, tipo de maíz, agricultor, etc.).
   - Haz clic en `Guardar`.
5. Desde la misma sección de Muestras de Maíz puedes:
   - Ver las muestras que has registrado.
   - Editar o eliminar tus registros.
   - Consultar el detalle de una muestra específica haciendo clic sobre ella.

## Notas sobre Sail

Este repositorio incluye configuración de Laravel Sail, pero fue renombrada a `compose.sail.yaml` para evitar conflictos con `docker-compose.yml`. (Docker Compose suele elegir `compose.yaml` automáticamente si existe).

- Para el stack principal (recomendado)
  
  ```bash
    docker compose up -d --build
  ```
  
- Si alguna vez quieres usar Sail explícitamente:
  
  ```bash
  docker compose -f compose.sail.yaml up -d
  ```

## Autor

- Alejandro Olvera Delgado - [GitHub](https://github.com/AlejandroDev8)
