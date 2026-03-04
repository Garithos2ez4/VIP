<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'client' => [
                    'nombre'        => 'Carlos',
                    'apellidos'     => 'Ramírez Mendoza',
                    'nro_documento' => '12345678',
                    'correo'        => 'carlos.ramirez@vip2cars.com',
                    'telefono'      => '+51 987 654 321',
                ],
                'vehicles' => [
                    ['placa' => 'ABC-123', 'marca' => 'Toyota',    'modelo' => 'Hilux',   'anio_fabricacion' => 2021],
                    ['placa' => 'DEF-456', 'marca' => 'Toyota',    'modelo' => 'Corolla', 'anio_fabricacion' => 2022],
                ],
            ],
            [
                'client' => [
                    'nombre'        => 'Lucía',
                    'apellidos'     => 'Fernández Castro',
                    'nro_documento' => '87654321',
                    'correo'        => 'lucia.fernandez@gmail.com',
                    'telefono'      => '+51 912 345 678',
                ],
                'vehicles' => [
                    ['placa' => 'GHI-789', 'marca' => 'BMW',       'modelo' => 'X5',      'anio_fabricacion' => 2023],
                ],
            ],
            [
                'client' => [
                    'nombre'        => 'Miguel',
                    'apellidos'     => 'Torres Quispe',
                    'nro_documento' => '45612378',
                    'correo'        => 'miguel.torres@hotmail.com',
                    'telefono'      => '+51 999 111 222',
                ],
                'vehicles' => [
                    ['placa' => 'JKL-012', 'marca' => 'Mercedes',  'modelo' => 'GLE 450', 'anio_fabricacion' => 2022],
                    ['placa' => 'MNO-345', 'marca' => 'Audi',      'modelo' => 'Q7',      'anio_fabricacion' => 2020],
                ],
            ],
            [
                'client' => [
                    'nombre'        => 'Sofía',
                    'apellidos'     => 'Vega Lozano',
                    'nro_documento' => '32178956',
                    'correo'        => 'sofia.vega@outlook.com',
                    'telefono'      => '+51 933 777 888',
                ],
                'vehicles' => [
                    ['placa' => 'PQR-678', 'marca' => 'Porsche',   'modelo' => 'Cayenne', 'anio_fabricacion' => 2024],
                ],
            ],
            [
                'client' => [
                    'nombre'        => 'Andrés',
                    'apellidos'     => 'Salinas Huanca',
                    'nro_documento' => '65498732',
                    'correo'        => 'andres.salinas@vip2cars.com',
                    'telefono'      => '+51 955 444 555',
                ],
                'vehicles' => [
                    ['placa' => 'STU-901', 'marca' => 'Lexus',     'modelo' => 'LX 600',  'anio_fabricacion' => 2023],
                    ['placa' => 'VWX-234', 'marca' => 'Range Rover','modelo' => 'Sport',  'anio_fabricacion' => 2021],
                    ['placa' => 'YZA-567', 'marca' => 'Ferrari',   'modelo' => 'Roma',    'anio_fabricacion' => 2022],
                ],
            ],
        ];

        foreach ($data as $entry) {
            $client = Client::create($entry['client']);
            foreach ($entry['vehicles'] as $v) {
                $client->vehicles()->create($v);
            }
        }
    }
}
