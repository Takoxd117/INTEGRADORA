<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // <--- Agrega esta línea para que funcione la relación workers

class reportes extends Model // Asegúrate de que este nombre sea igual al del controlador
{
    protected $table = 'reportes'; 

    protected $fillable = [
        'nombre_report', 
        'telefono', 
        'correo', 
        'calle', 
        'numero', 
        'colonia', 
        'referencia', 
        'tipo', 
        'numero_servicio', 
        'latitude', 
        'longitude', 
        'status'
    ];

    public function workers()
{
    return $this->belongsToMany(User::class, 'report_worker', 'reportes_id', 'user_id');
}
}