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
        Schema::table('users', function (Blueprint $table) {
        $table->string('CURP')->nullable()->unique();
        $table->string('calle')->nullable();
        $table->string('numero')->nullable();
        $table->string('colonia')->nullable();
        $table->string('municipio')->nullable();
        $table->string('telefono1')->nullable();
        $table->string('telefono2')->nullable();
        $table->date('fecha_ingreso')->nullable();
        $table->enum('role', ['admin', 'empleado', 'ciudadano'])->default('ciudadano');});

        Schema::create('report_worker', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained('reportes')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
