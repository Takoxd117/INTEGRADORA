<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reportes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    /**
     * Listado con filtros de estado y búsqueda por número de servicio.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = reportes::query();

        // 1. Lógica para Admin: Filtros y Búsqueda
        if ($user->role === 'admin') {
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('search')) {
                $query->where('numero_servicio', 'like', '%' . $request->search . '%');
            }
        } 
        // 2. Lógica para Empleado: Solo ve lo asignado "Sin revisar"
        elseif ($user->role === 'empleado') {
            $query->whereHas('workers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->where('status', 'Sin revisar');
        } 
        // 3. Lógica para Ciudadano: Solo ve sus reportes
        else {
            $query->where('correo', $user->email);
        }

        $reportes = $query->orderBy('created_at', 'desc')->get();

        return view('admin.reportes.index', compact('reportes'));
    }

    /**
     * Guardar nuevo reporte desde el ciudadano.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'calle' => 'required|string',
            'numero' => 'required|string',
            'colonia' => 'required|string',
            'telefono' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $rutaImagen = $request->hasFile('imagen') ? $request->file('imagen')->store('reportes', 'public') : null;

        reportes::create([
            'nombre_report'   => auth()->user()->name . ' - ' . $request->tipo,
            'tipo'            => $request->tipo,
            'calle'           => $request->calle,
            'numero'          => $request->numero,
            'colonia'         => $request->colonia,
            'telefono'        => $request->telefono,
            'correo'          => auth()->user()->email,
            'status'          => 'Sin revisar',
            'imagen'          => $rutaImagen,
            'numero_servicio' => $request->numero_servicio,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'referencia'      => $request->referencia,
        ]);

        return redirect()->route('dashboard')->with('success', 'Reporte enviado con éxito.');
    }

    public function show($id)
    {
        $reporte = reportes::with('workers')->findOrFail($id);
        $trabajadores = User::where('role', 'empleado')->get();
        return view('admin.reportes.show', compact('reporte', 'trabajadores'));
    }

    public function assign(Request $request, $id)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $reporte = reportes::findOrFail($id);
        $reporte->workers()->syncWithoutDetaching([$request->user_id]);
        $reporte->update(['status' => 'Sin revisar']);

        return redirect()->back()->with('success', 'Empleado asignado correctamente.');
    }

    /**
     * Finaliza el reporte sin notificaciones externas.
     */
    public function finalizar($id)
    {
        $reporte = reportes::findOrFail($id);
        
        // Solo Admin o el empleado asignado pueden finalizar
        if (Auth::user()->role === 'admin' || $reporte->workers()->where('users.id', Auth::id())->exists()) {
            
            $reporte->update(['status' => 'Revisado']);
            return redirect()->route('admin.reportes.index')->with('success', 'Reporte marcado como finalizado.');
        }

        return redirect()->back()->with('error', 'No tienes permisos para esta acción.');
    }

    public function detachWorker($reporteId, $workerId)
    {
        $reporte = reportes::findOrFail($reporteId);
        $reporte->workers()->detach($workerId);
        if($reporte->workers()->count() == 0) { 
            $reporte->update(['status' => 'Sin revisar']); 
        }
        return redirect()->back()->with('success', 'Empleado retirado del reporte.');
    }
}