<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('reportes', function (Blueprint $table) {
        $table->id();
        // Datos del reportante
        $table->string('nombre_report'); 
        $table->string('telefono'); 
        $table->string('correo');

        // Dirección de la falla
        $table->string('calle');
        $table->string('numero');
        $table->string('colonia'); // <-- Antes decía 'colonio', hay que corregirlo a 'colonia'
        $table->text('referencia');
        
        // Detalles técnicos
        $table->string('tipo'); 
        $table->string('numero_servicio');
        
        // NUEVO: Coordenadas GPS (Para que el botón funcione)
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        
        $table->dateTime('fecha_reporte')->useCurrent();
        
        // Estado
        $table->enum('status', ['Sin revisar', 'Por revisar', 'Revisado'])->default('Sin revisar');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
