<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Listar todos los empleados/admins
    public function index()
    {
        // Asegúrate de usar "User" (el nombre de tu modelo), no "Model"
        $users = User::whereIn('role', ['admin', 'empleado'])->get();
        
        return view('admin.users.index', compact('users'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.users.create');
    }

    // Guardar el nuevo trabajador
    public function store(Request $request)
{
    // 1. Quitamos 'fecha_ingreso' de aquí porque la generamos abajo automáticamente
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email:rfc,dns|max:255|unique:users',
        'password' => 'required|min:8|confirmed',
        'curp' => 'required|string|size:18|unique:users',
        'role' => 'required',
        'telefono1' => 'required',
        // 'fecha_ingreso' ya no debe estar aquí
    ]);

    // 2. Creamos el usuario
    User::create([
        'name' => $request->name,
        'email' => $request->email, // Verifica si es 'email' o 'correo' en tu DB (usualmente es email)
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'curp' => $request->curp,
        'calle' => $request->calle,
        'numero' => $request->numero,
        'colonia' => $request->colonia,
        'municipio' => $request->municipio ?? 'Zamora', // Valor por defecto si viene vacío
        'telefono1' => $request->telefono1,
        'telefono2' => $request->telefono2,
        'fecha_ingreso' => now()->toDateString(), // Se llena solo
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Personal registrado con éxito.');
}
    public function show($id)
{
    // Buscamos el reporte o lanzamos error 404 si no existe
    $reporte = \App\Models\reportes::findOrFail($id);
    
    // Aquí también podrías obtener a los usuarios con rol 'trabajador' para asignarlos
    $trabajadores = \App\Models\User::all(); // O filtrar por rol si tienes esa lógica

    return view('admin.reportes.show', compact('reporte', 'trabajadores'));
}
    
}