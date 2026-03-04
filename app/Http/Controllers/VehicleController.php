<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display a paginated list of vehicles with optional search.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $vehicles = Vehicle::with('client')
            ->when($search, function ($query, $search) {
                $query->where('placa', 'like', "%{$search}%")
                    ->orWhere('marca', 'like', "%{$search}%")
                    ->orWhere('modelo', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%")
                          ->orWhere('apellidos', 'like', "%{$search}%")
                          ->orWhere('nro_documento', 'like', "%{$search}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles', 'search'));
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    /**
     * Store a new vehicle (and create a new client record).
     */
    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        $client = Client::create($request->only([
            'nombre', 'apellidos', 'nro_documento', 'correo', 'telefono',
        ]));

        $vehicle = $client->vehicles()->create($request->only([
            'placa', 'marca', 'modelo', 'anio_fabricacion',
        ]));

        return redirect()
            ->route('vehicles.index')
            ->with('success', "Vehículo <strong>{$vehicle->placa}</strong> registrado exitosamente.");
    }

    /**
     * Show details for a single vehicle.
     */
    public function show(Vehicle $vehicle): View
    {
        $vehicle->load('client');
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the edit form.
     */
    public function edit(Vehicle $vehicle): View
    {
        $vehicle->load('client');
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update an existing vehicle and its client.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->client->update($request->only([
            'nombre', 'apellidos', 'nro_documento', 'correo', 'telefono',
        ]));

        $vehicle->update($request->only([
            'placa', 'marca', 'modelo', 'anio_fabricacion',
        ]));

        return redirect()
            ->route('vehicles.index')
            ->with('success', "Vehículo <strong>{$vehicle->placa}</strong> actualizado correctamente.");
    }

    /**
     * Soft-delete a vehicle.
     */
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $placa = $vehicle->placa;
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', "Vehículo <strong>{$placa}</strong> eliminado del sistema.");
    }
}
