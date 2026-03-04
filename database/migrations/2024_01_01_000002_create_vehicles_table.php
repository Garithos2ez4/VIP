<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 20)->unique();
            $table->string('marca', 80);
            $table->string('modelo', 100);
            $table->smallInteger('anio_fabricacion');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('placa');
            $table->index('marca');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
