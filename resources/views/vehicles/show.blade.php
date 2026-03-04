@extends('layouts.app')

@section('title', 'Detalle – ' . $vehicle->placa)

@section('content')
<div class="mb-4 d-flex align-items-center gap-3 flex-wrap">
    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary-custom btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="h4 fw-bold mb-0" style="color:var(--accent2);">
        <i class="bi bi-eye-fill me-2"></i>Detalle del Vehículo
    </h1>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-primary btn-sm px-3">
            <i class="bi bi-pencil-fill me-1"></i>Editar
        </a>
        <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}"
              onsubmit="return confirm('¿Eliminar el vehículo {{ $vehicle->placa }}?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm px-3" id="delete-detail-{{ $vehicle->id }}">
                <i class="bi bi-trash-fill me-1"></i>Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    {{-- ── Vehículo ─────────────────────────────────────────────── --}}
    <div class="col-lg-6">
        <div class="card-dark h-100">
            <div class="card-header">
                <h2 class="h6 mb-0 fw-semibold" style="color:var(--accent2);">
                    <i class="bi bi-car-front-fill me-2"></i>Vehículo
                </h2>
            </div>
            <div class="p-4">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted small">Placa</dt>
                    <dd class="col-7">
                        <span class="badge badge-placa px-2 py-1 fs-6">{{ $vehicle->placa }}</span>
                    </dd>

                    <dt class="col-5 text-muted small mt-2">Marca</dt>
                    <dd class="col-7 mt-2 fw-semibold">{{ $vehicle->marca }}</dd>

                    <dt class="col-5 text-muted small mt-2">Modelo</dt>
                    <dd class="col-7 mt-2">{{ $vehicle->modelo }}</dd>

                    <dt class="col-5 text-muted small mt-2">Año de fabricación</dt>
                    <dd class="col-7 mt-2">{{ $vehicle->anio_fabricacion }}</dd>

                    <dt class="col-5 text-muted small mt-2">Registrado el</dt>
                    <dd class="col-7 mt-2 small">{{ $vehicle->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- ── Cliente ──────────────────────────────────────────────── --}}
    <div class="col-lg-6">
        <div class="card-dark h-100">
            <div class="card-header">
                <h2 class="h6 mb-0 fw-semibold" style="color:var(--accent2);">
                    <i class="bi bi-person-vcard-fill me-2"></i>Cliente
                </h2>
            </div>
            <div class="p-4">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted small">Nombre</dt>
                    <dd class="col-7 fw-semibold">{{ $vehicle->client->full_name }}</dd>

                    <dt class="col-5 text-muted small mt-2">Nro. Documento</dt>
                    <dd class="col-7 mt-2 font-monospace">{{ $vehicle->client->nro_documento }}</dd>

                    <dt class="col-5 text-muted small mt-2">Correo</dt>
                    <dd class="col-7 mt-2">
                        <a href="mailto:{{ $vehicle->client->correo }}" style="color:var(--accent2);">
                            {{ $vehicle->client->correo }}
                        </a>
                    </dd>

                    <dt class="col-5 text-muted small mt-2">Teléfono</dt>
                    <dd class="col-7 mt-2">
                        <a href="tel:{{ $vehicle->client->telefono }}" style="color:var(--accent2);">
                            {{ $vehicle->client->telefono }}
                        </a>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
