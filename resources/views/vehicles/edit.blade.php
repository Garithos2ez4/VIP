@extends('layouts.app')

@section('title', 'Editar Vehículo – ' . $vehicle->placa)

@section('content')
<div class="mb-4 d-flex align-items-center gap-2">
    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary-custom btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
    <h1 class="h4 fw-bold mb-0" style="color:var(--accent2);">
        <i class="bi bi-pencil-fill me-2"></i>Editar Vehículo
        <span class="badge badge-placa ms-2">{{ $vehicle->placa }}</span>
    </h1>
</div>

<form method="POST" action="{{ route('vehicles.update', $vehicle) }}" novalidate id="edit-vehicle-form">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- ── Datos del Vehículo ─────────────────────────────────── --}}
        <div class="col-lg-6">
            <div class="card-dark h-100">
                <div class="card-header">
                    <h2 class="h6 mb-0 fw-semibold" style="color:var(--accent2);">
                        <i class="bi bi-car-front-fill me-2"></i>Datos del Vehículo
                    </h2>
                </div>
                <div class="p-4">

                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa <span class="text-warning">*</span></label>
                        <input type="text" id="placa" name="placa"
                               class="form-control form-control-dark text-uppercase @error('placa') is-invalid @enderror"
                               value="{{ old('placa', $vehicle->placa) }}" maxlength="20" required>
                        @error('placa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca <span class="text-warning">*</span></label>
                        <input type="text" id="marca" name="marca"
                               class="form-control form-control-dark @error('marca') is-invalid @enderror"
                               value="{{ old('marca', $vehicle->marca) }}" maxlength="80" required>
                        @error('marca') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo <span class="text-warning">*</span></label>
                        <input type="text" id="modelo" name="modelo"
                               class="form-control form-control-dark @error('modelo') is-invalid @enderror"
                               value="{{ old('modelo', $vehicle->modelo) }}" maxlength="100" required>
                        @error('modelo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="anio_fabricacion" class="form-label">Año de fabricación <span class="text-warning">*</span></label>
                        <input type="number" id="anio_fabricacion" name="anio_fabricacion"
                               class="form-control form-control-dark @error('anio_fabricacion') is-invalid @enderror"
                               value="{{ old('anio_fabricacion', $vehicle->anio_fabricacion) }}"
                               min="1900" max="{{ date('Y') + 1 }}" required>
                        @error('anio_fabricacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Datos del Cliente ──────────────────────────────────── --}}
        <div class="col-lg-6">
            <div class="card-dark h-100">
                <div class="card-header">
                    <h2 class="h6 mb-0 fw-semibold" style="color:var(--accent2);">
                        <i class="bi bi-person-vcard-fill me-2"></i>Datos del Cliente
                    </h2>
                </div>
                <div class="p-4">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="nombre" class="form-label">Nombre <span class="text-warning">*</span></label>
                            <input type="text" id="nombre" name="nombre"
                                   class="form-control form-control-dark @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre', $vehicle->client->nombre) }}" maxlength="100" required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="apellidos" class="form-label">Apellidos <span class="text-warning">*</span></label>
                            <input type="text" id="apellidos" name="apellidos"
                                   class="form-control form-control-dark @error('apellidos') is-invalid @enderror"
                                   value="{{ old('apellidos', $vehicle->client->apellidos) }}" maxlength="150" required>
                            @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="nro_documento" class="form-label">Nro. Documento <span class="text-warning">*</span></label>
                        <input type="text" id="nro_documento" name="nro_documento"
                               class="form-control form-control-dark @error('nro_documento') is-invalid @enderror"
                               value="{{ old('nro_documento', $vehicle->client->nro_documento) }}" maxlength="20" required>
                        @error('nro_documento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico <span class="text-warning">*</span></label>
                        <input type="email" id="correo" name="correo"
                               class="form-control form-control-dark @error('correo') is-invalid @enderror"
                               value="{{ old('correo', $vehicle->client->correo) }}" maxlength="150" required>
                        @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="text-warning">*</span></label>
                        <input type="tel" id="telefono" name="telefono"
                               class="form-control form-control-dark @error('telefono') is-invalid @enderror"
                               value="{{ old('telefono', $vehicle->client->telefono) }}" maxlength="20" required>
                        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 mt-4 justify-content-end">
        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-x-lg me-1"></i>Cancelar
        </a>
        <button type="submit" class="btn btn-primary-custom px-5" id="submit-edit">
            <i class="bi bi-floppy-fill me-1"></i>Actualizar
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('placa').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
@endpush
