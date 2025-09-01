@extends('layouts.app')

@section('content')
<style>
    /* Colores corporativos de Acuacode y fondos del dashboard */
    body{
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #003366, #00AEEF);
            color: #ffffff;
            margin: 0;
            padding: 0;
    }
    :root {
        --acuacode-blue-dark: #1a535c;
        --acuacode-green-light: #6bb746;
        --acuacode-blue-light: #40bfff;
        --acuacode-gradient-start: #003366; /* Inicio del degradado de tu sidebar */
        --acuacode-gradient-end: #00AEEF; /* Fin del degradado de tu sidebar */
    }

    /* Estilo para el bloque principal, similar al mensaje "You're logged in!" */
    .dashboard-message-block {
        /* Degradado de fondo del sidebar */
        background: linear-gradient(to bottom, var(--acuacode-gradient-start), var(--acuacode-gradient-end));
        border-radius: 8px; /* Bordes redondeados */
        padding: 1.5rem 2rem; /* Espaciado interno, un poco más pequeño */
        margin-bottom: 2rem;
        color: white; /* Texto claro */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Sombra para profundidad */
    }

    .dashboard-message-header {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--acuacode-green-light); /* Título en verde corporativo */
    }

    .dashboard-message-text {
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Contenedor para las tres tarjetas de datos inferiores */
    .data-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .data-card {
        background-color: #39B54A;
        border-radius: 50px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        text-align: center;
        color: white;
        opacity: 0.7;
        
    }
.data-card:hover {
    opacity: 1;
    }
    
    .data-card-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--acuacode-blue-dark);
        margin-bottom: 0.5rem;
    }

    .data-card-value {
        font-size: 2rem;
        font-weight: 700;
    }
</style>
<body>
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="dashboard-message-block">
            <h1 class="dashboard-message-header">¡Bienvenido a Acuacode!</h1>
            <p class="dashboard-message-text">
                Nuestro sistema acuapónico integra peces y plantas en un ciclo natural y autosustentable. Los peces generan nutrientes que alimentan a las plantas, y estas purifican el agua para devolverla al ecosistema. Así logramos una producción limpia, eficiente y respetuosa con el medio ambiente, utilizando hasta un 90% menos de agua que la agricultura tradicional.
                Con la acuaponía, producimos alimentos frescos y saludables, combinando innovación, sostenibilidad y tecnología en un solo sistema.
            </p>
        </div>

        <div class="data-card-container">
            <div class="data-card">
                <h3 class="data-card-title"><strong>Sensores Activos</strong></h3>
                <p class="data-card-value">12</p>
            </div>
            <div class="data-card">
                <h3 class="data-card-title"><strong>Alertas Críticas</strong></h3>
                <p class="data-card-value">0</p>
            </div>
            <div class="data-card">
                <h3 class="data-card-title"><strong>Temperatura Prom.</strong></h3>
                <p class="data-card-value">25.3 °C</p>
            </div>
        </div>
    </div>
</div>    
</body>

@endsection