@extends('layouts.app')

@section('content')
<div class="monitor-container">
    <div class="panel">
        <!-- Encabezado -->
        <div>
            <h1>Simulador de sensores criticos</h1>
            <p class="lead">Seguimiento continuo de los parámetros críticos del sistema acuapónico</p>
        </div>
        <!-- Botón de control -->
        <div class="controls" style="justify-content: center; margin: 30px 0;">
            <button class="btn-light" onclick="iniciarSimulacion()" id="btnIniciar">Iniciar Monitoreo</button>
            <button class="btn-light" onclick="detenerSimulacion()" id="btnDetener" style="display: none;">Detener Monitoreo</button>
        </div>

        <!-- Grid de gráficas -->
        <div class="grid-container">
            <div class="grafica-card">
                <div class="grafica-header">
                    <h3>🌡️ Temperatura del Agua</h3>
                    <span class="valor-actual" id="valorTemperatura">-- °C</span>
                </div>
                <div class="grafica-container">
                    <canvas id="graficaTemperatura"></canvas>
                </div>
            </div>

            <div class="grafica-card">
                <div class="grafica-header">
                    <h3>🧪 pH del Agua</h3>
                    <span class="valor-actual" id="valorPH">--</span>
                </div>
                <div class="grafica-container">
                    <canvas id="graficaPH"></canvas>
                </div>
            </div>

            <div class="grafica-card">
                <div class="grafica-header">
                    <h3>💧 Humedad Ambiental</h3>
                    <span class="valor-actual" id="valorHumedad">-- %</span>
                </div>
                <div class="grafica-container">
                    <canvas id="graficaHumedad"></canvas>
                </div>
            </div>

            <div class="grafica-card">
                <div class="grafica-header">
                    <h3>💨 Oxígeno Disuelto</h3>
                    <span class="valor-actual" id="valorOxigenacion">-- mg/L</span>
                </div>
                <div class="grafica-container">
                    <canvas id="graficaOxigenacion"></canvas>
                </div>
            </div>
        </div>

        <!-- Estado del sistema -->
        <div class="status-row">
            <div>Estado del Monitoreo:</div>
            <div class="status-list">
                <div class="dot" id="statusDot" style="background:#ef4444"></div>
                <span id="statusText">Inactivo</span>
            </div>
        </div>

        <footer>
            Sistema de Monitoreo Acuapónico • Actualización en tiempo real
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const valoresMaximos = 15;
    const tamañoMuestra = 3;

    const buffers = {
        temperatura: [],
        ph: [],
        humedad: [],
        oxigenacion: []
    };

    const datos = {
        etiquetas: [],
        temperatura: [],
        ph: [],
        humedad: [],
        oxigenacion: []
    };

    let graficas = {};
    let intervaloSimulacion;

    function crearGrafica(idCanvas, etiqueta, color) {
        const ctx = document.getElementById(idCanvas).getContext('2d');
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: datos.etiquetas,
                datasets: [{
                    label: etiqueta,
                    data: [],
                    borderColor: color,
                    backgroundColor: color + '20',
                    borderWidth: 2,
                    pointBackgroundColor: color,
                    pointBorderColor: '#fff',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        },
                        ticks: {
                            color: '#e6eef8',
                            maxTicksLimit: 6
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.1)'
                        },
                        ticks: {
                            color: '#e6eef8'
                        }
                    }
                }
            }
        });
    }

    window.onload = function () {
        graficas.temperatura = crearGrafica("graficaTemperatura", "Temperatura (°C)", "#06b6d4");
        graficas.ph = crearGrafica("graficaPH", "pH", "#10b981");
        graficas.humedad = crearGrafica("graficaHumedad", "Humedad (%)", "#8b5cf6");
        graficas.oxigenacion = crearGrafica("graficaOxigenacion", "Oxigenación (mg/L)", "#f59e0b");
    };

    function iniciarSimulacion() {
        if (intervaloSimulacion) clearInterval(intervaloSimulacion);
        
        document.getElementById('btnIniciar').style.display = 'none';
        document.getElementById('btnDetener').style.display = 'block';
        document.getElementById('statusDot').style.background = '#16a34a';
        document.getElementById('statusText').textContent = 'Activo';

        intervaloSimulacion = setInterval(() => {
            const lectura = {
                temperatura: parseFloat((Math.random() * 5 + 22).toFixed(1)), // 22-27 °C
                ph: parseFloat((Math.random() * 1.5 + 6.5).toFixed(2)),      // 6.5-8.0
                humedad: parseFloat((Math.random() * 30 + 50).toFixed(1)),   // 50-80 %
                oxigenacion: parseFloat((Math.random() * 3 + 5).toFixed(1))  // 5-8 mg/L
            };

            // Actualizar valores actuales
            document.getElementById('valorTemperatura').textContent = lectura.temperatura + ' °C';
            document.getElementById('valorPH').textContent = lectura.ph;
            document.getElementById('valorHumedad').textContent = lectura.humedad + ' %';
            document.getElementById('valorOxigenacion').textContent = lectura.oxigenacion + ' mg/L';

            // Acumular en buffers
            buffers.temperatura.push(lectura.temperatura);
            buffers.ph.push(lectura.ph);
            buffers.humedad.push(lectura.humedad);
            buffers.oxigenacion.push(lectura.oxigenacion);

            if (buffers.temperatura.length === tamañoMuestra) {
                const promedio = {
                    temperatura: promedioDeArray(buffers.temperatura),
                    ph: promedioDeArray(buffers.ph),
                    humedad: promedioDeArray(buffers.humedad),
                    oxigenacion: promedioDeArray(buffers.oxigenacion)
                };

                agregarDatos(promedio);

                // Limpiar buffers
                buffers.temperatura = [];
                buffers.ph = [];
                buffers.humedad = [];
                buffers.oxigenacion = [];
            }
        }, 2000);
    }

    function detenerSimulacion() {
        if (intervaloSimulacion) {
            clearInterval(intervaloSimulacion);
            intervaloSimulacion = null;
        }
        
        document.getElementById('btnIniciar').style.display = 'block';
        document.getElementById('btnDetener').style.display = 'none';
        document.getElementById('statusDot').style.background = '#ef4444';
        document.getElementById('statusText').textContent = 'Inactivo';
    }

    function promedioDeArray(arr) {
        const suma = arr.reduce((a, b) => a + b, 0);
        return parseFloat((suma / arr.length).toFixed(2));
    }

    function agregarDatos(promedio) {
        const timestamp = new Date().toLocaleTimeString();
        datos.etiquetas.push(timestamp);
        datos.temperatura.push(promedio.temperatura);
        datos.ph.push(promedio.ph);
        datos.humedad.push(promedio.humedad);
        datos.oxigenacion.push(promedio.oxigenacion);

        if (datos.etiquetas.length > valoresMaximos) {
            datos.etiquetas.shift();
            datos.temperatura.shift();
            datos.ph.shift();
            datos.humedad.shift();
            datos.oxigenacion.shift();
        }

        // Actualizar gráficas
        graficas.temperatura.data.labels = datos.etiquetas;
        graficas.temperatura.data.datasets[0].data = datos.temperatura;
        graficas.temperatura.update();

        graficas.ph.data.labels = datos.etiquetas;
        graficas.ph.data.datasets[0].data = datos.ph;
        graficas.ph.update();

        graficas.humedad.data.labels = datos.etiquetas;
        graficas.humedad.data.datasets[0].data = datos.humedad;
        graficas.humedad.update();

        graficas.oxigenacion.data.labels = datos.etiquetas;
        graficas.oxigenacion.data.datasets[0].data = datos.oxigenacion;
        graficas.oxigenacion.update();
    }
</script>

<style>
    /* ---- Estilos originales ---- */
    :root{
      --bg:#0f172a;
      --card:#0b1220;
      --text:#e6eef8;
      --accent:#06b6d4;
      --gap:18px;
      --btn-size:140px;
      --on-color:#16a34a;
      --off-color:#e11d48;
      --muted:#9aa6bd;
    }
    *{box-sizing:border-box;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial}
    
    /* Quitar el marco blanco del layout */
    body, main, .container {
        background: linear-gradient(180deg, #071021 0%, #062033 100%) !important;
        margin: 0;
        padding: 0;
        border: none;
    }
    
    .monitor-container {
        min-height: calc(100vh - 60px);
        background: transparent !important;
        color: var(--text);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel {
        width: 100%;
        max-width: 1200px;
        background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
        border-radius: 14px;
        padding: 26px;
        box-shadow: 0 8px 30px rgba(2,6,23,0.6);
        border: 1px solid rgba(255,255,255,0.03);
    }

    .header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .logo {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--accent), #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 24px;
    }

    h1 {
        margin: 0;
        font-size: 24px;
        color: var(--text);
    }

    p.lead {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: var(--gap);
        margin: 30px 0;
    }

    .grafica-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255,255,255,0.03);
    }

    .grafica-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .grafica-header h3 {
        margin: 0;
        font-size: 1.1rem;
        color: var(--accent);
    }

    .valor-actual {
        background: rgba(6, 182, 212, 0.1);
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #06b6d4;
    }

    .grafica-container {
        width: 100%;
        height: 200px;
        position: relative;
    }

    .controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 30px 0;
    }

    .btn-light {
        padding: 12px 24px;
        border-radius: 8px;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.06);
        color: var(--muted);
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-light:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.1);
        color: var(--text);
    }

    .status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
        color: var(--text);
    }

    .status-list {
        display: flex;
        gap: 12px;
        align-items: center;
        color: var(--text);
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--muted);
    }

    footer {
        margin-top: 20px;
        color: var(--muted);
        font-size: 13px;
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    /* Asegurar que todo el texto sea blanco */
    body, h1, h2, h3, h4, h5, h6, p, span, div, label, button {
        color: var(--text) !important;
    }

    /* Específicamente para los números y texto de Chart.js */
    .chartjs-render-monitor {
        color: var(--text) !important;
    }

    @media (max-width: 900px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
        
        .panel {
            padding: 20px;
        }
        
        .grafica-container {
            height: 180px;
        }
    }

    @media (max-width: 680px) {
        .monitor-container {
            padding: 15px;
        }
        
        .grafica-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        
        .valor-actual {
            align-self: flex-end;
        }
        
        .header {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
    }
</style>
@endsection
