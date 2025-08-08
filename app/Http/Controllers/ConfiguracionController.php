<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Muestra el formulario para editar la configuración del establecimiento.
     * Si no existe un registro, lo crea con valores predeterminados.
     */
    public function edit()
    {
        // Busca el primer (y único) registro de configuración
        $configuracion = Configuracion::first();

        // Si no existe, crea un registro vacío para el formulario
        if (!$configuracion) {
            $configuracion = new Configuracion();
        }

        return view('admin.configuracion.edit', compact('configuracion'));
    }

    /**
     * Actualiza la configuración del establecimiento.
     */
    public function update(Request $request)
    {
        $request->validate([
            'banco' => 'required|string|max:255',
            'numero_cuenta' => 'required|string|max:255',
            'nombre_titular' => 'required|string|max:255',
            'tipo_cuenta' => 'nullable|string|max:255',
            'numero_contacto' => 'required|string|max:255',
        ]);

        // Busca el primer registro de configuración
        $configuracion = Configuracion::first();

        // Si no existe, crea uno nuevo. Si existe, lo actualiza.
        // Esto garantiza que siempre haya un solo registro de configuración
        if (!$configuracion) {
            Configuracion::create($request->all());
        } else {
            $configuracion->update($request->all());
        }

        // Redirecciona de vuelta con un mensaje de éxito
        return redirect()->route('admin.configuracion.edit')->with('status', '¡Configuración actualizada con éxito!');
    }
}
