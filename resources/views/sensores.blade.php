@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-[#003366] mb-6">Sensores del Sistema Acuapónico</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Sensor Temperatura -->
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-[#00AEEF]">
            <h2 class="text-lg font-semibold text-[#003366]">🌡️ Temperatura del Agua</h2>
            <p class="mt-2 text-gray-600">25 °C</p>
        </div>

        <!-- Sensor pH -->
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-[#7AC943]">
            <h2 class="text-lg font-semibold text-[#003366]">⚗️ Nivel de pH</h2>
            <p class="mt-2 text-gray-600">6.8</p>
        </div>

        <!-- Sensor Oxígeno -->
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-[#00AEEF]">
            <h2 class="text-lg font-semibold text-[#003366]">💧 Oxígeno Disuelto</h2>
            <p class="mt-2 text-gray-600">7.5 mg/L</p>
        </div>

        <!-- Sensor Nivel de Agua -->
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-[#7AC943]">
            <h2 class="text-lg font-semibold text-[#003366]">📏 Nivel de Agua</h2>
            <p class="mt-2 text-gray-600">80 %</p>
        </div>

    </div>
</div>
@endsection
