<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    // Listar todos los empleados y administradores
    public function index()
    {
        // Traemos a los usuarios que no son ciudadanos (personal operativo)
        $users = User::whereIn('role', ['admin', 'empleado'])->get();
        
        return view('admin.users.index', compact('users'));
    }

    // Mostrar formulario de creación de personal
    public function create()
    {
        return view('admin.users.create');
    }

    // Guardar el nuevo trabajador en la BD
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email:rfc,dns|max:255|unique:users',
            'password'  => 'required|min:8|confirmed',
            'curp'      => 'required|string|size:18|unique:users',
            'role'      => 'required|in:admin,empleado',
            'telefono1' => 'required|string|max:15',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'CURP'          => strtoupper($request->curp), // Lo guardamos en mayúsculas
            'calle'         => $request->calle,
            'numero'        => $request->numero,
            'colonia'       => $request->colonia,
            'municipio'     => $request->municipio ?? 'Gutiérrez Zamora',
            'telefono1'     => $request->telefono1,
            'telefono2'     => $request->telefono2,
            'fecha_ingreso' => now()->toDateString(), // Asignación automática
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Personal registrado correctamente en el sistema.');
    }

    /**
     * Muestra la información detallada de un empleado específico.
     */
    public function show($id)
    {
        // Buscamos al usuario por ID
        $user = User::findOrFail($id);
        
        // Retornamos la vista de perfil del usuario
        return view('admin.users.show', compact('user'));
    }

    /**
     * Elimina (Da de baja) a un usuario del sistema.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Seguridad: Evitar que el admin se borre a sí mismo
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'No puedes darte de baja a ti mismo.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'El usuario ha sido dado de baja exitosamente.');
    }
}