# VIP2CARS – Sistema de Gestión de Vehículos y Clientes

> Prueba técnica PHP/Laravel · Rubro Automotriz VIP2CARS

---

## 📋 Tabla de Contenidos

1. [Descripción del Proyecto](#descripción-del-proyecto)
2. [Estructura del Repositorio](#estructura-del-repositorio)
3. [Requisitos del Entorno](#-requisitos-del-entorno)
4. [Instalación y Configuración](#-instalación-y-configuración)
5. [Puesta en Marcha](#-puesta-en-marcha)
6. [Estructura de la Base de Datos](#-estructura-de-la-base-de-datos)
7. [Credenciales Demo](#-credenciales-demo)
8. [Funcionalidades](#-funcionalidades)

---

## Descripción del Proyecto

Mini-proyecto Laravel que demuestra:

- **Parte 1** – Modelado de BBDD: sistema de **encuestas anónimas** (ER diagram + SQL script).
- **Parte 2** – CRUD completo de **Vehículos y Contactos** para el rubro automotriz VIP2CARS.

---

## Estructura del Repositorio

```
vip2cars/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── VehicleController.php      # CRUD completo con búsqueda y paginación
│   │   └── Requests/
│   │       ├── StoreVehicleRequest.php    # Validación al crear
│   │       └── UpdateVehicleRequest.php   # Validación al actualizar
│   └── Models/
│       ├── Client.php                     # Cliente (hasMany vehicles)
│       └── Vehicle.php                    # Vehículo (belongsTo client)
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_clients_table.php
│   │   ├── 2024_01_01_000002_create_vehicles_table.php
│   │   └── 2024_01_01_000003_create_surveys_tables.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php             # Punto de entrada (usuario demo)
│   │   └── VehicleSeeder.php              # 5 clientes, 10 vehículos demo
│   └── sql/
│       └── schema.sql                     # Script SQL completo (encuestas + vehículos)
├── resources/
│   └── views/
│       ├── layouts/app.blade.php          # Layout principal (dark/gold theme)
│       └── vehicles/
│           ├── index.blade.php            # Lista + búsqueda + paginación
│           ├── create.blade.php           # Formulario de creación
│           ├── edit.blade.php             # Formulario de edición
│           └── show.blade.php             # Detalle del vehículo
├── routes/web.php
├── .env.example
└── README.md
```

---

## 🔧 Requisitos del Entorno

| Requisito | Versión mínima |
|-----------|----------------|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ (solo para compilar assets Breeze) |
| SQLite | 3.35+ (incluido en PHP) |
| **Alternativa DB** | MySQL 8+ / MariaDB 10.6+ |

**Extensiones PHP requeridas:**
`pdo_sqlite`, `mbstring`, `openssl`, `curl`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `bcmath`

---

## 🧰 Instalación y Configuración

```bash
# 1. Clonar el repositorio
git clone <URL_DEL_REPO> vip2cars
cd vip2cars

# 2. Instalar dependencias PHP
composer install --ignore-platform-reqs

# 3. Instalar dependencias Node (para compilar assets)
npm install

# 4. Copiar archivo de entorno
cp .env.example .env

# 5. Generar clave de la aplicación
php artisan key:generate

# 6. Crear la base de datos SQLite (o configurar MySQL en .env)
touch database/database.sqlite
# En Windows PowerShell:
# New-Item -ItemType File database\database.sqlite

# 7. Ejecutar migraciones y seeders
php artisan migrate:fresh --seed
```

### Configuración para MySQL (opcional)

Editar `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vip2cars
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

Luego crear la base de datos y ejecutar:
```bash
php artisan migrate:fresh --seed
```

---

## ▶️ Puesta en Marcha

```bash
# Terminal 1 – compilar assets (solo la primera vez o al modificar CSS/JS)
npm run build

# Terminal 2 – levantar el servidor de desarrollo
php artisan serve
```

Abrir en el navegador: **http://127.0.0.1:8000**

---

## 🗄️ Estructura de la Base de Datos

El script SQL completo está en [`database/sql/schema.sql`](database/sql/schema.sql).

### Parte 1 – Encuestas Anónimas

```
surveys       ──┐
                │ (1:N)
questions     ──┤ survey_id FK
                │ (1:N)
options       ──┤ question_id FK
                │
responses     ──┤ survey_id FK  ← anonymous_token (UUID, sin FK a users)
                │ (1:N)
answers        ─┘ response_id FK │ question_id FK │ option_id FK (nullable)
```

| Tabla | Propósito |
|-------|-----------|
| `surveys` | Encuesta (título, fechas, estado activo) |
| `questions` | Pregunta por encuesta (tipo: single/multiple/text) |
| `options` | Opciones de respuesta para preguntas de elección |
| `responses` | Una respuesta completa, identificada por UUID anónimo |
| `answers` | Respuesta individual a una pregunta (option_id o text) |

> **Anonimato:** No existe FK a una tabla `users`. El `anonymous_token` (UUID) identifica la sesión de respuesta sin vincularla a ningún usuario.

### Parte 2 – Vehículos y Clientes

| Tabla | Campos clave |
|-------|-------------|
| `clients` | `id`, `nombre`, `apellidos`, `nro_documento` (único), `correo` (único), `telefono`, `deleted_at` |
| `vehicles` | `id`, `placa` (único), `marca`, `modelo`, `anio_fabricacion`, `client_id` (FK), `deleted_at` |

- Ambas tablas usan **Soft Deletes** (campo `deleted_at`).
- Un cliente puede tener **múltiples vehículos**.

---

## 🔑 Credenciales Demo

| Campo | Valor |
|-------|-------|
| Email | `admin@vip2cars.com` |
| Contraseña | `password` |

El seeder también crea **5 clientes** y **10 vehículos** de ejemplo.

---

## 🚗 Funcionalidades

- ✅ **CRUD completo** de vehículos (crear, listar, ver detalle, editar, eliminar)
- ✅ **Búsqueda** por placa, marca, modelo, nombre/apellido de cliente o número de documento
- ✅ **Paginación** (10 registros por página) con query string preservado
- ✅ **Validaciones** completas server-side (unicidad de placa, documento y correo; año válido; formato de teléfono)
- ✅ **Mensajes de error** por campo con feedback visual
- ✅ **Flash messages** de éxito/error en todas las operaciones
- ✅ **Soft Deletes** (los registros eliminados se preservan en la DB)
- ✅ **Autenticación** con Laravel Breeze
- ✅ **Diseño responsivo** dark/gold con Bootstrap 5
- ✅ **Migraciones** y **seeders** documentados
- ✅ **SQL script** exportado en `database/sql/schema.sql`
