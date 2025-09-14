@extends('layouts.app')

@section('content')
<style>
    /* Nueva paleta de colores para el dashboard */
    body{
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom, #0d1b2a, #1b263b);
        color: #ffffff;
        margin: 0;
        padding: 0;
    }

    :root {
        --dashboard-blue-dark: #1b263b;
        --dashboard-green-light: #76c893;
        --dashboard-blue-light: #00b4d8;
        --dashboard-gradient-start: #0d1b2a; 
        --dashboard-gradient-end: #1b263b; 
        --dashboard-warning: #f4a261;
        --dashboard-critical: #e63946;
    }

    /* Bloque principal */
    .dashboard-message-block {
        background: linear-gradient(to right, var(--dashboard-gradient-start), var(--dashboard-gradient-end));
        border-radius: 10px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .dashboard-message-header {
        font-size: 1.7rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dashboard-green-light);
    }

    .dashboard-message-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #d9e6eb;
    }

    /* Tarjetas inferiores */
    .data-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .data-card {
        background: linear-gradient(135deg, #1e6091, #184e77);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
        text-align: center;
        color: white;
        transition: transform 0.2s ease, opacity 0.2s ease;
        opacity: 0.9;
    }

    .data-card:hover {
        transform: translateY(-5px);
        opacity: 1;
    }

    .data-card-title {
        font-size: 1.4rem;
        font-weight: 500;
        color: var(--dashboard-blue-light);
        margin-bottom: 0.5rem;
    }

    .data-card-value {
        font-size: 2rem;
        font-weight: 700;
    }

    /* Personalización por tipo de tarjeta */
    .data-card.alertas {
        background: linear-gradient(135deg, var(--dashboard-critical), #9d0208);
    }

    .data-card.sensores {
        background: linear-gradient(135deg, var(--dashboard-green-light), #2d6a4f);
    }

    .data-card.temperatura {
        background: linear-gradient(135deg, var(--dashboard-warning), #e9c46a);
        color: #1b263b;
    }
</style>

<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dashboard-message-block">
                <h1 class="dashboard-message-header">¡Bienvenido a Acuacode!</h1>
                <p class="dashboard-message-text">
                    Nuestro sistema acuapónico integra peces y plantas en un ciclo natural y autosustentable. 
                    Los peces generan nutrientes que alimentan a las plantas, y estas purifican el agua para devolverla al ecosistema. 
                    Así logramos una producción limpia, eficiente y respetuosa con el medio ambiente, utilizando hasta un 90% menos de agua que la agricultura tradicional.
                </p>
            </div>

            <div class="data-card-container">
                <div class="data-card sensores">
                    <h3 class="data-card-title"><strong>Sensores Activos</strong></h3>
                    <p class="data-card-value">12</p>
                </div>
                <div class="data-card alertas">
                    <h3 class="data-card-title"><strong>Alertas Críticas</strong></h3>
                    <p class="data-card-value">0</p>
                </div>
                <div class="data-card temperatura">
                    <h3 class="data-card-title"><strong>Temperatura Prom.</strong></h3>
                    <p class="data-card-value">25.3 °C</p>
                </div>
            </div>
        </div>
    </div>    
</body>

@endsection