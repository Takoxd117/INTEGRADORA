<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // El admin ve todos los reportes
        $reportes = \App\Models\reportes::orderBy('created_at', 'desc')->get();

    } elseif ($user->role === 'empleado') {
        // El empleado ve lo que tiene asignado y está "Por revisar"
        $reportes = \App\Models\reportes::whereHas('workers', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->where('status', 'Sin revisar')
        ->orderBy('created_at', 'desc')
        ->get();

    } else {
        // El CIUDADANO ve los reportes que él mismo levantó
        // Buscamos por su correo (según tu método store usas 'correo')
        $reportes = \App\Models\reportes::where('correo', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    return view('admin.reportes.index', compact('reportes'));
}

    // Nuevo método para que el empleado finalice su tarea
    public function finalizar($id)
    {
        $reporte = \App\Models\reportes::findOrFail($id);
        
        // Verificamos que el usuario sea un trabajador asignado a este reporte (por seguridad)
        $isAssigned = $reporte->workers()->where('users.id', Auth::id())->exists();

        if ($isAssigned || Auth::user()->role === 'admin') {
            $reporte->status = 'Revisado';
            $reporte->save();
            return redirect()->route('admin.reports.index')->with('success', 'Reporte marcado como revisado.');
        }

        return redirect()->back()->with('error', 'No tienes permiso para finalizar este reporte.');
    }

    public function show($id)
{
    // Cargamos el reporte con sus trabajadores actuales
    $reporte = \App\Models\reportes::with('workers')->findOrFail($id);
    
    // FILTRO: Solo obtener usuarios cuyo rol sea 'empleado'
    $trabajadores = \App\Models\User::where('role', 'empleado')->get(); 

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