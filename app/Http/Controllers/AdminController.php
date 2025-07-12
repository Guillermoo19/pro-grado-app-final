<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Muestra el dashboard de administración.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Log::info('AdminController@index: Dashboard de administración accedido.');
        return view('admin.dashboard'); // Asegúrate de que esta vista exista
    }

    // Puedes añadir otros métodos de administración aquí
}
