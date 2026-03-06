<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_worker', function (Blueprint $table) {
            $table->id();
            
            // Relación con la tabla reportes
            $table->unsignedBigInteger('reportes_id');
            $table->foreign('reportes_id')->references('id')->on('reportes')->onDelete('cascade');

            // Relación con la tabla users (empleados)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_worker');
    }
};