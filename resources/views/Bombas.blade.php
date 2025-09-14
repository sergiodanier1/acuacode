@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Parámetros Ambientales</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            max-width: 1000px;
            width: 100%;
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
        
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .data-card {
            background: linear-gradient(145deg, #ffffff, #f5f5f5);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .data-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }
        
        .data-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }
        
        .data-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        
        .data-card:hover .data-icon {
            transform: scale(1.1);
        }
        
        .data-title {
            font-size: 1.1rem;
            color: #777;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .data-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            transition: color 0.3s;
        }
        
        .data-unit {
            font-size: 1rem;
            color: #777;
            font-weight: 500;
        }
        
        .temperature::before { background: linear-gradient(to right, #ff7e5f, #feb47b); }
        .humidity::before { background: linear-gradient(to right, #00cdac, #02aab0); }
        .ph::before { background: linear-gradient(to right, #a8ff78, #78ffd6); }
        .oxygen::before { background: linear-gradient(to right, #8e2de2, #4a00e0); }
        
        .temperature .data-icon { color: #ff7e5f; }
        .humidity .data-icon { color: #00cdac; }
        .ph .data-icon { color: #a8ff78; }
        .oxygen .data-icon { color: #8e2de2; }
        
        .temperature:hover .data-value { color: #ff7e5f; }
        .humidity:hover .data-value { color: #00cdac; }
        .ph:hover .data-value { color: #a8ff78; }
        .oxygen:hover .data-value { color: #8e2de2; }
        
        .loading {
            text-align: center;
            padding: 40px;
            font-size: 1.2rem;
            color: #777;
        }
        
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
        
        @media (max-width: 768px) {
            .data-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            h1 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .data-grid {
                grid-template-columns: 1fr;
            }
            
            .status-bar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Monitor Ambiental</h1>
            <p>Sistema de monitoreo en tiempo real</p>
        </header>
        
        <div class="status-bar">
            <div class="last-update">Última actualización: <span id="update-time">-</span></div>
            <button class="refresh-btn" id="refresh-btn">
                <span>↻</span>
                <span>Actualizar Datos</span>
            </button>
        </div>
        
        <div class="error" id="error-message">
            Error al cargar los datos. Por favor, verifique la conexión e intente nuevamente.
        </div>
        
        <div class="data-grid">
            <div class="data-card temperature">
                <div class="data-icon">🌡️</div>
                <div class="data-title">Temperatura</div>
                <div class="data-value" id="temperature">--</div>
                <div class="data-unit">°C</div>
            </div>
            
            <div class="data-card humidity">
                <div class="data-icon">💧</div>
                <div class="data-title">Humedad</div>
                <div class="data-value" id="humidity">--</div>
                <div class="data-unit">%</div>
            </div>
            
            <div class="data-card ph">
                <div class="data-icon">🧪</div>
                <div class="data-title">pH</div>
                <div class="data-value" id="ph">--</div>
                <div class="data-unit">nivel</div>
            </div>
            
            <div class="data-card oxygen">
                <div class="data-icon">💨</div>
                <div class="data-title">Oxígeno Disuelto</div>
                <div class="data-value" id="oxygen">--</div>
                <div class="data-unit">mg/L</div>
            </div>
        </div>
        
        <footer>
            <p>Sistema de monitoreo | Datos obtenidos de sensores en tiempo real</p>
            <div class="data-source">Fuente: http://192.168.1.12/data</div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const temperatureElement = document.getElementById('temperature');
            const humidityElement = document.getElementById('humidity');
            const phElement = document.getElementById('ph');
            const oxygenElement = document.getElementById('oxygen');
            const updateTimeElement = document.getElementById('update-time');
            const refreshButton = document.getElementById('refresh-btn');
            const errorMessage = document.getElementById('error-message');
            
            // URL del endpoint (simulamos los datos ya que no podemos conectarnos directamente)
            const apiUrl = 'http://192.168.1.12/data';
            
            // Función para formatear la fecha y hora
            function formatDateTime(date) {
                const options = { 
                    year: 'numeric', 
                    month: '2-digit', 
                    day: '2-digit',
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                };
                return date.toLocaleString('es-ES', options);
            }
            
            // Función para obtener y mostrar los datos
            function fetchData() {
                errorMessage.style.display = 'none';
                
                // En un caso real, aquí haríamos fetch(apiUrl)
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
                    updateTimeElement.textContent = formatDateTime(new Date());
                    
                    // Añadir animación de actualización
                    const dataValues = document.querySelectorAll('.data-value');
                    dataValues.forEach(value => {
                        value.style.transition = 'all 0.5s ease';
                        value.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            value.style.transform = 'scale(1)';
                        }, 500);
                    });
                    
                } catch (error) {
                    console.error('Error:', error);
                    errorMessage.style.display = 'block';
                }
            }
            
            // Cargar datos al iniciar
            fetchData();
            
            // Configurar la actualización al hacer clic en el botón
            refreshButton.addEventListener('click', fetchData);
            
            // Actualizar automáticamente cada 15 segundos
            setInterval(fetchData, 15000);
        });
    </script>
</body>
</html>

@endsection