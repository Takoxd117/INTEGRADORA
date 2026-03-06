<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportesController extends Controller
{
    public function index()
{
    // Obtenemos todos los reportes, del más reciente al más antiguo
    $reportes = \App\Models\Reportes::orderBy('created_at', 'desc')->get();
    
    return view('admin.reportes.index', compact('reportes'));
}
    public function store(Request $request)
    {
        $data = $request->validate([
        'nombre_report' => 'required',
        'telefono' => 'required',
        'correo' => 'required|email',
        'calle' => 'required',
        'numero' => 'required',
        'colonia' => 'required',
        'referencia' => 'required',
        'tipo' => 'required',
        'numero_servicio' => 'required',
        'latitude' => 'nullable',
        'longitude' => 'nullable',
    ]);

    $data['status'] = 'Sin revisar';

    // USAR LA RUTA COMPLETA PARA EVITAR CONFUSIONES:
    \App\Models\reportes::create($data); 

    return redirect()->back()->with('success', 'Reporte enviado con éxito.');
    }

    public function show($id)
{
    // Usamos 'with' para cargar los trabajadores ya asignados de una vez (Eager Loading)
    $reporte = \App\Models\reportes::with('workers')->findOrFail($id);
    
    // Obtenemos todos los empleados para el dropdown de asignación
    $trabajadores = \App\Models\User::all(); 

    return view('admin.reportes.show', compact('reporte', 'trabajadores'));
}

    // Para guardar la asignación
    public function assign(Request $request, $id)
{
    // Buscamos manualmente usando tu modelo 'reportes'
    $reporte = \App\Models\reportes::findOrFail($id);
    
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    // Usamos la relación workers que definimos en el modelo
    $reporte->workers()->syncWithoutDetaching([$request->user_id]);

    return redirect()->back()->with('success', 'Empleado asignado correctamente.');
}
}