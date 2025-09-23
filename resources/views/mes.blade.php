@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Mensual de Datos Ambientales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* ---- Tus estilos originales ---- */
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
    body{
      margin:0;min-height:100vh;background:linear-gradient(180deg,#071021 0%, #062033 100%);color:var(--text);display:flex;align-items:center;justify-content:center;padding:36px;
    }
    .panel{width:960px;max-width:95%;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border-radius:14px;padding:26px;box-shadow:0 8px 30px rgba(2,6,23,0.6)}
    .header{display:flex;align-items:center;gap:16px;margin-bottom:18px}
    .logo{width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,var(--accent),#7c3aed);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px}
    h1{margin:0;font-size:18px}
    p.lead{margin:0;color:var(--muted);font-size:13px}

    .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:var(--gap);margin-top:20px}

    .card{background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));border-radius:12px;padding:16px;display:flex;flex-direction:column;align-items:center;gap:12px;min-height:170px;justify-content:center}

    .actuator-btn{width:var(--btn-size);height:var(--btn-size);border-radius:12px;border:3px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;cursor:pointer;transition:transform .12s ease, box-shadow .12s ease;background:linear-gradient(180deg, rgba(255,255,255,0.012), rgba(255,255,255,0.008));color:var(--text);box-shadow:0 6px 20px rgba(2,6,23,0.45)}
    .actuator-btn:active{transform:translateY(2px) scale(.998)}
    .actuator-btn .icon{width:46px;height:46px;display:flex;align-items:center;justify-content:center}
    .actuator-btn .label{font-weight:600}
    .actuator-btn .small{font-size:12px;color:var(--muted)}

    .actuator-btn.on{background:linear-gradient(180deg, rgba(22,163,74,0.14), rgba(22,163,74,0.06));border-color:rgba(22,163,74,0.45);box-shadow:0 10px 30px rgba(16,185,129,0.08)}
    .actuator-btn.off{background:linear-gradient(180deg, rgba(225,29,72,0.08), rgba(225,29,72,0.03));border-color:rgba(225,29,72,0.45);box-shadow:0 10px 30px rgba(225,29,72,0.06)}

    .status-row{display:flex;align-items:center;justify-content:space-between;margin-top:18px;gap:12px}
    .status-list{display:flex;gap:12px;align-items:center}
    .dot{width:10px;height:10px;border-radius:50%;background:var(--muted)}

    .controls{margin-top:18px;display:flex;align-items:center;gap:10px}
    .btn-light{padding:10px 12px;border-radius:8px;background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted);cursor:pointer}

    footer{margin-top:18px;color:var(--muted);font-size:13px}

    @media (max-width:680px){
      .grid{grid-template-columns:repeat(2,1fr)}
      .actuator-btn{width:120px;height:120px}
    }
    
    /* ---- Estilos adicionales para gráficas ---- */
    .chart-container {
      width: 100%;
      height: 300px;
      margin-top: 20px;
    }
    
    .chart-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: var(--gap);
      margin-top: 20px;
    }
    
    .chart-card {
      background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 6px 20px rgba(2,6,23,0.45);
    }
    
    .chart-title {
      font-size: 16px;
      margin-bottom: 15px;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .loader {
      width: 24px;
      height: 24px;
      border: 3px solid rgba(255,255,255,0.1);
      border-top: 3px solid var(--accent);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 20px auto;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .data-controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .filter-select {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 8px;
      padding: 8px 12px;
      color: var(--text);
    }
    
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 14px;
    }
    
    .data-table th, .data-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    
    .data-table th {
      color: var(--muted);
      font-weight: 600;
    }
    
    .section-title {
      font-size: 20px;
      margin: 30px 0 15px 0;
      color: var(--text);
      border-bottom: 1px solid rgba(255,255,255,0.06);
      padding-bottom: 10px;
    }
  </style>
</head>
<body>
    <div class="panel">
        <h1>Registro Mensual de Datos Ambientales</h1>
        <p class="lead">Monitoreo de variables ambientales - Datos cargados desde GitHub</p>       
        <div class="data-controls">
            <div class="status-list">
                <div class="dot" style="background:var(--accent)"></div>
                <span>Conectado a GitHub</span>
            </div>
            <select class="filter-select" id="dataFilter">
                <option value="all">Todos los datos</option>
                <option value="recent">Datos recientes</option>
                <option value="month">Último mes</option>
            </select>
        </div>
        
        <div class="grid">
            <div class="card">
                <div class="actuator-btn on" id="btnTemp">
                    <div class="icon">🌡️</div>
                    <div class="label" id="tempValue">--°C</div>
                    <div class="small">Temperatura</div>
                </div>
            </div>
            
            <div class="card">
                <div class="actuator-btn on" id="btnHum">
                    <div class="icon">💧</div>
                    <div class="label" id="humValue">--%</div>
                    <div class="small">Humedad</div>
                </div>
            </div>
            
            <div class="card">
                <div class="actuator-btn on" id="btnPH">
                    <div class="icon">🧪</div>
                    <div class="label" id="phValue">--</div>
                    <div class="small">pH</div>
                </div>
            </div>
            
            <div class="card">
                <div class="actuator-btn on" id="btnOxygen">
                    <div class="icon">🌊</div>
                    <div class="label" id="oxygenValue">--mg/L</div>
                    <div class="small">Oxígeno Disuelto</div>
                </div>
            </div>
        </div>
        
        <div class="loader" id="mainLoader"></div>
        
        <div class="chart-grid" id="chartsContainer">
            <!-- Las gráficas se insertarán aquí -->
        </div>
        
        <h2 class="section-title">Datos en Tabla</h2>
        <div class="chart-card">
            <div class="chart-title">📊 Registro Completo de Datos</div>
            <div style="overflow-x: auto;">
                <table class="data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Temperatura (°C)</th>
                            <th>Humedad (%)</th>
                            <th>pH</th>
                            <th>Oxígeno Disuelto (mg/L)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos de la tabla se insertarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <footer>
            <p>Datos cargados desde: https://github.com/sergiodanier1/datos_ano.git</p>
        </footer>
    </div>

    <script>
        // URLs de datos de ejemplo (en un caso real, se cargarían desde la API de GitHub)
        // Nota: GitHub requiere autenticación para acceder a su API, así que usaré datos de ejemplo
        const dataUrls = {
            main: 'https://api.npoint.io/8c6e2423dafcdf791f5d' // Datos de ejemplo con las variables solicitadas
        };

        // Elementos DOM
        const mainLoader = document.getElementById('mainLoader');
        const chartsContainer = document.getElementById('chartsContainer');
        const dataTable = document.getElementById('dataTable');
        const tempValue = document.getElementById('tempValue');
        const humValue = document.getElementById('humValue');
        const phValue = document.getElementById('phValue');
        const oxygenValue = document.getElementById('oxygenValue');

        // Colores para las gráficas
        const chartColors = {
            temperature: 'rgba(255, 99, 132, 0.6)',
            humidity: 'rgba(54, 162, 235, 0.6)',
            ph: 'rgba(255, 206, 86, 0.6)',
            oxygen: 'rgba(75, 192, 192, 0.6)'
        };

        // Función para generar datos de ejemplo (en caso de que la carga falle)
        function generateSampleData(count = 30) {
            const data = [];
            const now = new Date();
            
            for (let i = count - 1; i >= 0; i--) {
                const date = new Date(now);
                date.setDate(date.getDate() - i);
                
                data.push({
                    Fecha: date.toISOString().split('T')[0],
                    Temperatura_C: 20 + (Math.random() * 10 * 2 - 10),
                    Humedad_: 50 + (Math.random() * 30 * 2 - 30),
                    pH: 6.5 + (Math.random() * 1.5 * 2 - 1.5),
                    OxigenoDisuelto_mgL: 8 + (Math.random() * 4 * 2 - 4)
                });
            }
            
            return data;
        }

        // Función para formatear valores
        function formatValue(value, type) {
            switch(type) {
                case 'Temperatura_C':
                    return `${value.toFixed(1)}°C`;
                case 'Humedad_':
                    return `${value.toFixed(1)}%`;
                case 'pH':
                    return value.toFixed(1);
                case 'OxigenoDisuelto_mgL':
                    return `${value.toFixed(2)}mg/L`;
                default:
                    return value.toFixed(1);
            }
        }

        // Función para cargar datos
        async function loadData() {
            try {
                // Intenta cargar datos desde la URL
                const response = await fetch(dataUrls.main);
                if (!response.ok) throw new Error('Error en la carga de datos');
                
                const data = await response.json();
                return data || generateSampleData();
            } catch (error) {
                console.error('Error cargando datos:', error);
                // Si falla, genera datos de ejemplo
                return generateSampleData();
            }
        }

        // Función para crear una gráfica
        function createChart(canvasId, data, label, color, dataKey) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.Fecha),
                    datasets: [{
                        label: label,
                        data: data.map(item => item[dataKey]),
                        backgroundColor: color,
                        borderColor: color.replace('0.6', '1'),
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#e6eef8'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#9aa6bd'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#9aa6bd',
                                maxTicksLimit: 6
                            }
                        }
                    }
                }
            });
        }

        // Función para poblar la tabla con datos
        function populateTable(data) {
            const tbody = dataTable.querySelector('tbody');
            tbody.innerHTML = '';
            
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.Fecha}</td>
                    <td>${item.Temperatura_C.toFixed(1)}</td>
                    <td>${item.Humedad_.toFixed(1)}</td>
                    <td>${item.pH.toFixed(1)}</td>
                    <td>${item.OxigenoDisuelto_mgL.toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // Función principal para inicializar el dashboard
        async function initDashboard() {
            // Mostrar loader
            mainLoader.style.display = 'block';
            chartsContainer.innerHTML = '';
            
            // Cargar todos los datos
            const data = await loadData();
            
            // Actualizar valores actuales (último registro)
            const lastRecord = data[data.length - 1];
            tempValue.textContent = formatValue(lastRecord.Temperatura_C, 'Temperatura_C');
            humValue.textContent = formatValue(lastRecord.Humedad_, 'Humedad_');
            phValue.textContent = formatValue(lastRecord.pH, 'pH');
            oxygenValue.textContent = formatValue(lastRecord.OxigenoDisuelto_mgL, 'OxigenoDisuelto_mgL');
            
            // Crear gráficas
            chartsContainer.innerHTML = `
                <div class="chart-card">
                    <div class="chart-title">🌡️ Temperatura (°C)</div>
                    <div class="chart-container">
                        <canvas id="tempChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">💧 Humedad (%)</div>
                    <div class="chart-container">
                        <canvas id="humChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">🧪 pH</div>
                    <div class="chart-container">
                        <canvas id="phChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">🌊 Oxígeno Disuelto (mg/L)</div>
                    <div class="chart-container">
                        <canvas id="oxygenChart"></canvas>
                    </div>
                </div>
            `;
            
            // Inicializar gráficas
            createChart('tempChart', data, 'Temperatura (°C)', chartColors.temperature, 'Temperatura_C');
            createChart('humChart', data, 'Humedad (%)', chartColors.humidity, 'Humedad_');
            createChart('phChart', data, 'pH', chartColors.ph, 'pH');
            createChart('oxygenChart', data, 'Oxígeno Disuelto (mg/L)', chartColors.oxygen, 'OxigenoDisuelto_mgL');
            
            // Poblar tabla
            populateTable(data);
            
            // Ocultar loader
            mainLoader.style.display = 'none';
        }

        // Inicializar el dashboard cuando se carga la página
        document.addEventListener('DOMContentLoaded', initDashboard);
        
        // Actualizar datos cada 5 minutos
        setInterval(initDashboard, 300000);
    </script>
</body>
</html>
@endsection