<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
            'banco' => 'nullable|required_if:payment_method,bank_transfer|string|max:255',
            'numero_cuenta' => 'nullable|required_if:payment_method,bank_transfer|string|max:255',
            'nombre_titular' => 'nullable|required_if:payment_method,bank_transfer|string|max:255',
            'tipo_cuenta' => 'nullable|string|max:255',
            'numero_contacto' => 'required|string|max:255',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
        ]);

        // Busca el primer registro de configuración
        $configuracion = Configuracion::first();

        // Si no existe, crea uno nuevo. Si existe, lo actualiza.
        if (!$configuracion) {
            $configuracion = new Configuracion();
        }

        // Manejo de la subida de imagen del QR
        if ($request->hasFile('qr_image')) {
            // Eliminar la imagen anterior si existe
            if ($configuracion->qr_image_path) {
                Storage::disk('public')->delete($configuracion->qr_image_path);
            }
            // Guarda la nueva imagen en el directorio public/images/qrcodes
            $path = $request->file('qr_image')->store('images/qrcodes', 'public');
            $configuracion->qr_image_path = $path;
        }

        // Actualiza los demás campos
        // Esta línea estaba causando el error porque la columna 'metodo_pago' no existe en la tabla.
        // $configuracion->metodo_pago = $validatedData['payment_method'];

        $configuracion->banco = $validatedData['banco'] ?? null;
        $configuracion->numero_cuenta = $validatedData['numero_cuenta'] ?? null;
        $configuracion->nombre_titular = $validatedData['nombre_titular'] ?? null;
        $configuracion->tipo_cuenta = $validatedData['tipo_cuenta'] ?? null;
        $configuracion->numero_contacto = $validatedData['numero_contacto'];

        $configuracion->save();

        // Redirecciona de vuelta con un mensaje de éxito
        return redirect()->route('admin.configuracion.edit')->with('status', '¡Configuración actualizada con éxito!');
    }
}
