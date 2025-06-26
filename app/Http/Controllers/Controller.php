<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Importa el trait AuthorizesRequests
use Illuminate\Foundation\Bus\DispatchesJobs; // Importa el trait DispatchesJobs
use Illuminate\Foundation\Validation\ValidatesRequests; // Importa el trait ValidatesRequests
use Illuminate\Routing\Controller as BaseController; // Importa la clase base de Laravel

abstract class Controller extends BaseController // Ahora hereda de BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // Usa los traits
}