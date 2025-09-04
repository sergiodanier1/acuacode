<?php

namespace App\Http\Controllers;

use App\Models\Sensor;

class SensorController extends Controller
{
    public function index()
    {
        // Obtener todos los sensores
        $sensors = Sensor::all();

        // Retornar la vista con los datos
        return view('asensores', compact('sensors'));
    }
}


