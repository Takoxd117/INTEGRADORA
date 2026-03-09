<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reportes; // Asegúrate de que tu modelo se llame exactamente así
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    /**
     * Muestra el listado de reportes según el rol.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // El admin ve absolutamente todo
            $reportes = reportes::orderBy('created_at', 'desc')->get();
        } elseif ($user->role === 'empleado') {
            // El empleado ve lo asignado que está en proceso ("Por revisar")
            $reportes = reportes::whereHas('workers', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->where('status', 'Sin revisar')
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            // El ciudadano ve los reportes que coinciden con su correo
            $reportes = reportes::where('correo', $user->email)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('admin.reportes.index', compact('reportes'));
    }

    /**
     * Guarda un nuevo reporte (Método que te faltaba para el Ciudadano).
     */
    public function store(Request $request)
{
    // 1. Validamos todos los campos que tu modelo permite
    $request->validate([
        'tipo' => 'required|string',
        'calle' => 'required|string',
        'numero' => 'required|string',
        'colonia' => 'required|string',
        'telefono' => 'required|string',
        // Otros campos pueden ser opcionales según tu base de datos
    ]);

    // 2. Creamos el reporte usando los campos de tu modelo
    \App\Models\reportes::create([
        'nombre_report'   => auth()->user()->name . ' - ' . $request->tipo,
        'tipo'            => $request->tipo,
        'calle'           => $request->calle,
        'numero'          => $request->numero,
        'colonia'         => $request->colonia,
        'telefono'        => $request->telefono,
        'correo'          => auth()->user()->email,
        'status'          => 'Sin revisar',
        // Puedes agregar estos si los tienes en el formulario:
        'numero_servicio' => $request->numero_servicio ?? null,
        'latitude'        => $request->latitude ?? null,
        'longitude'       => $request->longitude ?? null,
        'referencia'      => $request->referencia ?? null,
    ]);

    return redirect()->route('dashboard')->with('success', 'Reporte creado con éxito.');
}

    /**
     * Muestra el detalle de un reporte y la lista de empleados para asignar.
     */
    public function show($id)
    {
        $reporte = reportes::with('workers')->findOrFail($id);
        $trabajadores = User::where('role', 'empleado')->get(); 

        return view('admin.reportes.show', compact('reporte', 'trabajadores'));
    }

    /**
     * Asigna un técnico al reporte y cambia el estado.
     */
    public function assign(Request $request, $id)
{
    try {
        $reporte = reportes::findOrFail($id);
        
        // Agregamos un log para ver si llega el user_id
        $request->validate(['user_id' => 'required|exists:users,id']);

        $reporte->workers()->syncWithoutDetaching([$request->user_id]);

        $reporte->status = 'Sin revisar';
        $reporte->save();

        return redirect()->back()->with('success', 'Empleado asignado correctamente.');
        
    } catch (\Exception $e) {
        // CAMBIO AQUÍ: Esto mostrará el error real en la pantalla en lugar de un mensaje genérico
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * Retira a un trabajador de un reporte.
     */
    public function detachWorker($reporteId, $workerId)
    {
        $reporte = reportes::findOrFail($reporteId);
        $reporte->workers()->detach($workerId);

        if($reporte->workers()->count() == 0) {
            $reporte->status = 'Sin revisar';
            $reporte->save();
        }

        return redirect()->back()->with('success', 'Empleado retirado del reporte.');
    }

    /**
     * Finaliza el reporte (Estado 'Revisado' por el ENUM).
     */
    public function finalizar($id)
    {
        $reporte = reportes::findOrFail($id);
        $isAssigned = $reporte->workers()->where('users.id', Auth::id())->exists();

        if ($isAssigned || Auth::user()->role === 'admin') {
            $reporte->status = 'Revisado';
            $reporte->save();
            
            // CORRECCIÓN: Usamos 'admin.reportes.index' para evitar el RouteNotFoundException
            return redirect()->route('admin.reportes.index')->with('success', 'Reporte finalizado con éxito.');
        }

        return redirect()->back()->with('error', 'No tienes permiso.');
    }
}