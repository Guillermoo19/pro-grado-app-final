<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Esto asume que tienes un método de autorización, ajusta según sea necesario
        // $this->authorize('viewAny', Ingrediente::class);

        $ingredientes = Ingrediente::orderBy('nombre')->get();
        Log::info('IngredienteController@index: Lista de ingredientes para administración accedida por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('admin.ingredientes.index', compact('ingredientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $this->authorize('create', Ingrediente::class);
        Log::info('IngredienteController@create: Formulario de creación de ingrediente accedido por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('admin.ingredientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Ingrediente::class);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:ingredientes,nombre',
            'precio' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/', // Validación para el precio
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre del ingrediente es obligatorio.',
            'nombre.unique' => 'Este nombre de ingrediente ya existe.',
            'nombre.max' => 'El nombre del ingrediente no debe exceder los 255 caracteres.',
            'precio.required' => 'El precio del ingrediente es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El formato del precio no es válido.',
        ]);

        Ingrediente::create($validatedData);

        Log::info('IngredienteController@store: Ingrediente ' . $validatedData['nombre'] . ' creado exitosamente por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\Response
     */
    public function show(Ingrediente $ingrediente)
    {
        // Este método no tiene una vista implementada, por lo que redirigimos o devolvemos un 404
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\View\View
     */
    public function edit(Ingrediente $ingrediente)
    {
        // $this->authorize('update', $ingrediente);
        Log::info('IngredienteController@edit: Formulario de edición de ingrediente accedido para ID: ' . $ingrediente->id . ' por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return view('admin.ingredientes.edit', compact('ingrediente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ingrediente $ingrediente)
    {
        // $this->authorize('update', $ingrediente);

        $validatedData = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ingredientes')->ignore($ingrediente->id),
            ],
            'precio' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/', // Validación para el precio
            'descripcion' => 'nullable|string',
        ],
        [
            'nombre.required' => 'El nombre del ingrediente es obligatorio.',
            'nombre.unique' => 'Este nombre de ingrediente ya existe.',
            'nombre.max' => 'El nombre del ingrediente no debe exceder los 255 caracteres.',
            'precio.required' => 'El precio del ingrediente es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.regex' => 'El formato del precio no es válido.',
        ]);

        $ingrediente->update($validatedData);

        Log::info('IngredienteController@update: Ingrediente ' . $ingrediente->nombre . ' actualizado exitosamente por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingrediente  $ingrediente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ingrediente $ingrediente)
    {
        // $this->authorize('delete', $ingrediente);

        $ingrediente->delete();
        Log::info('IngredienteController@destroy: Ingrediente ' . $ingrediente->nombre . ' eliminado por ' . (Auth::check() ? Auth::user()->email : 'Invitado'));
        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente eliminado exitosamente.');
    }
}
