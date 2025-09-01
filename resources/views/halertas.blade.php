@extends('layouts.app')

@section('content')
<div class="p-6">
        <!-- Mensaje de bienvenida -->
        <div class="bg-gradient-to-r from-blue-900 to-blue-600 text-white rounded-2xl shadow-lg p-6 mb-8">
            <h1 class="text-2xl font-bold">🌊 Mensaje de Bienvenida</h1>
            <p class="mt-2 text-lg">
                Bienvenido al sistema <span class="font-semibold text-green-400">Acuacode</span>, 
                donde podrás monitorear y controlar tu ecosistema acuapónico en tiempo real.
            </p>
        </div>

        <!-- Bloques de Información Adicional -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📊 Bloques de Información Adicional</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Bloque 1 -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-t-4 border-blue-500 hover:shadow-xl transition">
                <h3 class="text-lg font-bold text-blue-700">Sensores Activos</h3>
                <p class="mt-2 text-gray-600">Visualiza y gestiona el estado de los sensores conectados.</p>
            </div>

            <!-- Bloque 2 -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-t-4 border-green-500 hover:shadow-xl transition">
                <h3 class="text-lg font-bold text-green-700">Datos en Tiempo Real</h3>
                <p class="mt-2 text-gray-600">Monitorea el comportamiento del sistema en vivo.</p>
            </div>

            <!-- Bloque 3 -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-t-4 border-blue-400 hover:shadow-xl transition">
                <h3 class="text-lg font-bold text-blue-600">Históricos</h3>
                <p class="mt-2 text-gray-600">Consulta y analiza registros anteriores para tomar mejores decisiones.</p>
            </div>
        </div>
    </div>
@endsection