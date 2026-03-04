@extends('layouts.app')

@section('title', 'Vehículos')

@section('content')
{{-- ── Header ────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1" style="color:var(--accent2);">
            <i class="bi bi-car-front-fill me-2"></i>Gestión de Vehículos
        </h1>
        <p class="text-muted mb-0 small">VIP2CARS – Registro de vehículos y contactos</p>
    </div>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary-custom px-4 py-2">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Vehículo
    </a>
</div>

{{-- ── Search ────────────────────────────────────────────────────────── --}}
<div class="card-dark mb-4 p-3">
    <form method="GET" action="{{ route('vehicles.index') }}" class="d-flex gap-2" id="search-form">
        <div class="input-group">
            <span class="input-group-text" style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.15);color:#aaa;">
                <i class="bi bi-search"></i>
            </span>
            <input type="text"
                   id="search"
                   name="search"
                   class="form-control form-control-dark"
                   placeholder="Buscar por placa, marca, modelo, cliente o documento…"
                   value="{{ $search ?? '' }}">
        </div>
        <button class="btn btn-primary-custom px-4" type="submit">Buscar</button>
        @if($search)
            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </form>
</div>

{{-- ── Results count ─────────────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="small text-muted">
        @if($search)
            <i class="bi bi-funnel-fill me-1" style="color:var(--accent)"></i>
            <strong style="color:var(--accent2)">{{ $vehicles->total() }}</strong> resultado(s) para «{{ $search }}»
        @else
            Total: <strong style="color:var(--accent2)">{{ $vehicles->total() }}</strong> vehículo(s) registrado(s)
        @endif
    </span>
    <span class="small text-muted">Página {{ $vehicles->currentPage() }} / {{ $vehicles->lastPage() }}</span>
</div>

{{-- ── Table ─────────────────────────────────────────────────────────── --}}
<div class="card-dark">
    <div class="table-responsive">
        <table class="table table-dark-custom table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="bi bi-card-text me-1"></i>Placa</th>
                    <th><i class="bi bi-tag-fill me-1"></i>Marca / Modelo</th>
                    <th><i class="bi bi-calendar3 me-1"></i>Año</th>
                    <th><i class="bi bi-person-fill me-1"></i>Cliente</th>
                    <th><i class="bi bi-envelope-fill me-1"></i>Correo</th>
                    <th><i class="bi bi-phone-fill me-1"></i>Teléfono</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $index => $vehicle)
                <tr>
                    <td class="text-muted small">{{ $vehicles->firstItem() + $index }}</td>
                    <td>
                        <span class="badge badge-placa px-2 py-1">{{ $vehicle->placa }}</span>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $vehicle->marca }}</div>
                        <div class="small text-muted">{{ $vehicle->modelo }}</div>
                    </td>
                    <td>{{ $vehicle->anio_fabricacion }}</td>
                    <td>
                        <div class="fw-semibold">{{ $vehicle->client->full_name }}</div>
                        <div class="small text-muted">DNI/Doc: {{ $vehicle->client->nro_documento }}</div>
                    </td>
                    <td class="small">{{ $vehicle->client->correo }}</td>
                    <td class="small">{{ $vehicle->client->telefono }}</td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('vehicles.show', $vehicle) }}"
                               class="btn btn-outline-info btn-sm" title="Ver detalle">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('vehicles.edit', $vehicle) }}"
                               class="btn btn-outline-primary btn-sm" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}"
                                  onsubmit="return confirm('¿Eliminar el vehículo {{ $vehicle->placa }}? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" title="Eliminar" id="delete-{{ $vehicle->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        No se encontraron vehículos{{ $search ? ' para «'.$search.'»' : '' }}.
                        <br>
                        <a href="{{ route('vehicles.create') }}" class="btn btn-primary-custom mt-3">
                            <i class="bi bi-plus-lg me-1"></i>Registrar el primero
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Pagination ─────────────────────────────────────────────────── --}}
    @if($vehicles->hasPages())
    <div class="d-flex justify-content-center py-3">
        {{ $vehicles->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
