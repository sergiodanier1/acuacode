@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Ambiental con Gráficos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        
        .last-update {
            font-size: 0.9rem;
            color: #777;
        }
        
        .refresh-btn {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .refresh-btn:active {
            transform: translateY(0);
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 900px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .chart-title {
            text-align: center;
            margin-bottom: 15px;
            color: #2c3e50;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .data-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .data-card {
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }
        
        .data-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .data-title {
            font-size: 1rem;
            color: #777;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .data-value {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .data-unit {
            font-size: 0.9rem;
            color: #777;
        }
        
        .temperature { border-top: 5px solid #ff7e5f; }
        .humidity { border-top: 5px solid #00cdac; }
        .ph { border-top: 5px solid #a8ff78; }
        .oxygen { border-top: 5px solid #8e2de2; }
        
        .temperature .data-icon { color: #ff7e5f; }
        .humidity .data-icon { color: #00cdac; }
        .ph .data-icon { color: #a8ff78; }
        .oxygen .data-icon { color: #8e2de2; }
        
        .error {
            text-align: center;
            padding: 20px;
            color: #e74c3c;
            background-color: #ffebee;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9rem;
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        .data-source {
            margin-top: 10px;
            font-size: 0.8rem;
            color: #3498db;
        }
        
        .chart-size {
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-chart-line"></i> Monitor Ambiental con Gráficos</h1>
            <p>Visualización en tiempo real de datos de sensores</p>
        </header>
        
        <div class="status-bar">
            <div class="last-update">Última actualización: <span id="update-time">-</span></div>
            <button class="refresh-btn" id="refresh-btn">
                <i class="fas fa-sync-alt"></i>
                <span>Actualizar Datos</span>
            </button>
        </div>
        
        <div class="error" id="error-message">
            <i class="fas fa-exclamation-circle"></i>
            Error al cargar los datos. Por favor, verifique la conexión e intente nuevamente.
        </div>
        
        <div class="data-cards">
            <div class="data-card temperature">
                <div class="data-icon"><i class="fas fa-temperature-high"></i></div>
                <div class="data-title">Temperatura</div>
                <div class="data-value" id="temperature">--</div>
                <div class="data-unit">°C</div>
            </div>
            
            <div class="data-card humidity">
                <div class="data-icon"><i class="fas fa-tint"></i></div>
                <div class="data-title">Humedad</div>
                <div class="data-value" id="humidity">--</div>
                <div class="data-unit">%</div>
            </div>
            
            <div class="data-card ph">
                <div class="data-icon"><i class="fas fa-vial"></i></div>
                <div class="data-title">pH</div>
                <div class="data-value" id="ph">--</div>
                <div class="data-unit">nivel</div>
            </div>
            
            <div class="data-card oxygen">
                <div class="data-icon"><i class="fas fa-wind"></i></div>
                <div class="data-title">Oxígeno Disuelto</div>
                <div class="data-value" id="oxygen">--</div>
                <div class="data-unit">mg/L</div>
            </div>
        </div>
        
        <div class="dashboard">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-temperature-high"></i>
                    <span>Temperatura (°C)</span>
                </div>
                <div class="chart-size">
                    <canvas id="tempChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-tint"></i>
                    <span>Humedad (%)</span>
                </div>
                <div class="chart-size">
                    <canvas id="humidityChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-vial"></i>
                    <span>Nivel de pH</span>
                </div>
                <div class="chart-size">
                    <canvas id="phChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-wind"></i>
                    <span>Oxígeno Disuelto (mg/L)</span>
                </div>
                <div class="chart-size">
                    <canvas id="oxygenChart"></canvas>
                </div>
            </div>
        </div>
        
        <footer>
            <p>Sistema de monitoreo con gráficos en tiempo real | Datos obtenidos de: http://192.168.1.12/data</p>
            <div class="data-source">Usando Chart.js para visualización de datos</div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos DOM
            const temperatureElement = document.getElementById('temperature');
            const humidityElement = document.getElementById('humidity');
            const phElement = document.getElementById('ph');
            const oxygenElement = document.getElementById('oxygen');
            const updateTimeElement = document.getElementById('update-time');
            const refreshButton = document.getElementById('refresh-btn');
            const errorMessage = document.getElementById('error-message');
            
            // Variables para almacenar datos históricos
            let timeLabels = [];
            let temperatureData = [];
            let humidityData = [];
            let phData = [];
            let oxygenData = [];
            
            // Inicializar gráficos
            const tempChart = new Chart(
                document.getElementById('tempChart'),
                createChartConfig('Temperatura (°C)', 'rgba(255, 126, 95, 0.7)', 'rgb(255, 126, 95)')
            );
            
            const humidityChart = new Chart(
                document.getElementById('humidityChart'),
                createChartConfig('Humedad (%)', 'rgba(0, 205, 172, 0.7)', 'rgb(0, 205, 172)')
            );
            
            const phChart = new Chart(
                document.getElementById('phChart'),
                createChartConfig('Nivel de pH', 'rgba(168, 255, 120, 0.7)', 'rgb(168, 255, 120)')
            );
            
            const oxygenChart = new Chart(
                document.getElementById('oxygenChart'),
                createChartConfig('Oxígeno Disuelto (mg/L)', 'rgba(142, 45, 226, 0.7)', 'rgb(142, 45, 226)')
            );
            
            // Configuración común para los gráficos
            function createChartConfig(label, bgColor, borderColor) {
                return {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: label,
                            data: [],
                            backgroundColor: bgColor,
                            borderColor: borderColor,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: borderColor,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                };
            }
            
            // Función para formatear la fecha y hora
            function formatDateTime(date) {
                const options = { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                };
                return date.toLocaleTimeString('es-ES', options);
            }
            
            // Función para obtener y mostrar los datos
            function fetchData() {
                errorMessage.style.display = 'none';
                
                // En un caso real, aquí haríamos fetch('http://192.168.1.12/data')
                // Pero como es una demostración, simulamos la respuesta
                try {
                    // Simulamos una respuesta del servidor
                    const responseData = {
                        temperatura: (25 + Math.random() * 2).toFixed(1),
                        humedad: (55 + Math.random() * 10).toFixed(1),
                        ph: (6.8 + Math.random() * 0.8).toFixed(1),
                        oxigeno: (5 + Math.random() * 2).toFixed(1)
                    };
                    
                    // Actualizar los valores en la interfaz
                    temperatureElement.textContent = responseData.temperatura;
                    humidityElement.textContent = responseData.humedad;
                    phElement.textContent = responseData.ph;
                    oxygenElement.textContent = responseData.oxigeno;
                    
                    // Actualizar la hora de la última actualización
                    const now = new Date();
                    updateTimeElement.textContent = formatDateTime(now);
                    
                    // Añadir datos a los históricos
                    const timeLabel = formatDateTime(now);
                    timeLabels.push(timeLabel);
                    
                    // Mantener solo los últimos 10 datos
                    if (timeLabels.length > 10) {
                        timeLabels.shift();
                        temperatureData.shift();
                        humidityData.shift();
                        phData.shift();
                        oxygenData.shift();
                    }
                    
                    // Agregar nuevos datos
                    temperatureData.push(parseFloat(responseData.temperatura));
                    humidityData.push(parseFloat(responseData.humedad));
                    phData.push(parseFloat(responseData.ph));
                    oxygenData.push(parseFloat(responseData.oxigeno));
                    
                    // Actualizar gráficos
                    updateChart(tempChart, timeLabels, temperatureData);
                    updateChart(humidityChart, timeLabels, humidityData);
                    updateChart(phChart, timeLabels, phData);
                    updateChart(oxygenChart, timeLabels, oxygenData);
                    
                } catch (error) {
                    console.error('Error:', error);
                    errorMessage.style.display = 'block';
                }
            }
            
            // Función para actualizar un gráfico
            function updateChart(chart, labels, data) {
                chart.data.labels = labels;
                chart.data.datasets[0].data = data;
                chart.update();
            }
            
            // Cargar datos iniciales
            for (let i = 0; i < 5; i++) {
                // Simular algunos datos iniciales
                const mockDate = new Date();
                mockDate.setMinutes(mockDate.getMinutes() - (5 - i));
                
                timeLabels.push(formatDateTime(mockDate));
                temperatureData.push(24.5 + Math.random() * 2);
                humidityData.push(50 + Math.random() * 15);
                phData.push(6.5 + Math.random() * 1.5);
                oxygenData.push(4.5 + Math.random() * 2);
            }
            
            // Inicializar gráficos con datos iniciales
            updateChart(tempChart, timeLabels, temperatureData);
            updateChart(humidityChart, timeLabels, humidityData);
            updateChart(phChart, timeLabels, phData);
            updateChart(oxygenChart, timeLabels, oxygenData);
            
            // Cargar datos actuales
            fetchData();
            
            // Configurar la actualización al hacer clic en el botón
            refreshButton.addEventListener('click', fetchData);
            
            // Actualizar automáticamente cada 5 segundos
            setInterval(fetchData, 5000);
        });
    </script>
</body>
</html>

@endsection