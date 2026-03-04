<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Vehicle fields
            'placa'            => ['required', 'string', 'max:20', 'unique:vehicles,placa', 'regex:/^[A-Z0-9\-]+$/i'],
            'marca'            => ['required', 'string', 'max:80'],
            'modelo'           => ['required', 'string', 'max:100'],
            'anio_fabricacion' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            // Client fields
            'nombre'           => ['required', 'string', 'max:100'],
            'apellidos'        => ['required', 'string', 'max:150'],
            'nro_documento'    => ['required', 'string', 'max:20', 'unique:clients,nro_documento'],
            'correo'           => ['required', 'email', 'max:150', 'unique:clients,correo'],
            'telefono'         => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\s]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'placa.unique'            => 'Ya existe un vehículo registrado con esa placa.',
            'placa.regex'             => 'La placa solo puede contener letras, números y guiones.',
            'anio_fabricacion.min'    => 'El año de fabricación no puede ser anterior a 1900.',
            'anio_fabricacion.max'    => 'El año de fabricación no puede ser futuro.',
            'nro_documento.unique'    => 'Ya existe un cliente con ese número de documento.',
            'correo.unique'           => 'Ya existe un cliente con ese correo electrónico.',
            'telefono.regex'          => 'El teléfono solo puede contener números, +, - y espacios.',
        ];
    }
}
