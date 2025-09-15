@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de LEDs ESP32</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 30px;
            margin-top: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            color: #7f8c8d;
            font-size: 1.2rem;
        }
        
        .leds-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .led-control {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        
        .led-control:hover {
            transform: translateY(-5px);
        }
        
        .led-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .led-visual {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 15px;
            background-color: #7f8c8d;
            border: 4px solid #2c3e50;
            transition: background-color 0.3s ease;
        }
        
        .led-visual.on {
            background-color: #ffdd00;
            box-shadow: 0 0 20px #ffdd00, 0 0 40px rgba(255, 221, 0, 0.5);
        }
        
        .status {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        
        .status.on {
            background-color: #2ecc71;
            color: white;
        }
        
        .status.off {
            background-color: #e74c3c;
            color: white;
        }
        
        .control-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }
        
        button {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #2980b9, #3498db);
        }
        
        button.toggle-on {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }
        
        button.toggle-off {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .instructions {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            border-left: 5px solid #3498db;
        }
        
        .instructions h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .instructions p {
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .code-block {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            overflow-x: auto;
            margin: 15px 0;
        }
        
        footer {
            margin-top: 30px;
            text-align: center;
            color: white;
            font-size: 0.9rem;
        }
        
        @media (max-width: 600px) {
            .leds-container {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Control de LEDs ESP32</h1>
            <p class="subtitle">Estado actual de los LEDs - http://127.0.0.1:8000/Control/bombas</p>
        </header>
        
        <div class="leds-container">
            <div class="led-control">
                <div class="led-title">LED 1</div>
                <div class="led-visual off" id="visual1"></div>
                <div class="status off" id="status1">APAGADO</div>
                <div class="control-buttons">
                    <button class="toggle-on" onclick="toggleLED(1, true)">ENCENDER</button>
                    <button class="toggle-off" onclick="toggleLED(1, false)">APAGAR</button>
                </div>
            </div>
            
            <div class="led-control">
                <div class="led-title">LED 2</div>
                <div class="led-visual off" id="visual2"></div>
                <div class="status off" id="status2">APAGADO</div>
                <div class="control-buttons">
                    <button class="toggle-on" onclick="toggleLED(2, true)">ENCENDER</button>
                    <button class="toggle-off" onclick="toggleLED(2, false)">APAGAR</button>
                </div>
            </div>
            
            <div class="led-control">
                <div class="led-title">LED 3</div>
                <div class="led-visual off" id="visual3"></div>
                <div class="status off" id="status3">APAGADO</div>
                <div class="control-buttons">
                    <button class="toggle-on" onclick="toggleLED(3, true)">ENCENDER</button>
                    <button class="toggle-off" onclick="toggleLED(3, false)">APAGAR</button>
                </div>
            </div>
            
            <div class="led-control">
                <div class="led-title">LED 4</div>
                <div class="led-visual off" id="visual4"></div>
                <div class="status off" id="status4">APAGADO</div>
                <div class="control-buttons">
                    <button class="toggle-on" onclick="toggleLED(4, true)">ENCENDER</button>
                    <button class="toggle-off" onclick="toggleLED(4, false)">APAGAR</button>
                </div>
            </div>
        </div>
        
        <div class="instructions">
            <h3>Instrucciones para el ESP32</h3>
            <p>El ESP32 debe consultar regularmente esta página web para conocer el estado de los LEDs. Aquí tienes un ejemplo de código para el ESP32:</p>
            
            <div class="code-block">
// Ejemplo de código para ESP32<br>
#include &lt;WiFi.h&gt;<br>
#include &lt;HTTPClient.h&gt;<br>
<br>
const char* ssid = "TU_SSID";<br>
const char* password = "TU_PASSWORD";<br>
<br>
// URL de tu página web<br>
const char* serverURL = "http://127.0.0.1:8000/Control/bombas";<br>
<br>
// Pines de los LEDs<br>
const int ledPins[] = {2, 4, 5, 18};<br>
<br>
void setup() {<br>
  Serial.begin(115200);<br>
  <br>
  // Conectar a WiFi<br>
  WiFi.begin(ssid, password);<br>
  while (WiFi.status() != WL_CONNECTED) {<br>
    delay(1000);<br>
    Serial.println("Conectando a WiFi...");<br>
  }<br>
  <br>
  // Configurar pines de LEDs como salida<br>
  for (int i = 0; i < 4; i++) {<br>
    pinMode(ledPins[i], OUTPUT);<br>
    digitalWrite(ledPins[i], LOW);<br>
  }<br>
}<br>
<br>
void loop() {<br>
  if (WiFi.status() == WL_CONNECTED) {<br>
    HTTPClient http;<br>
    http.begin(serverURL);<br>
    int httpCode = http.GET();<br>
    <br>
    if (httpCode > 0) {<br>
      String payload = http.getString();<br>
      <br>
      // Aquí debes parsear el HTML para encontrar el estado de cada LED<br>
      // y actualizar los LEDs físicos según corresponda<br>
      <br>
      // Ejemplo simplificado:<br>
      for (int i = 0; i < 4; i++) {<br>
        if (payload.indexOf("LED " + String(i+1) + " - ENCENDIDO") != -1) {<br>
          digitalWrite(ledPins[i], HIGH);<br>
        } else {<br>
          digitalWrite(ledPins[i], LOW);<br>
        }<br>
      }<br>
    }<br>
    http.end();<br>
  }<br>
  delay(5000); // Esperar 5 segundos entre consultas<br>
}
            </div>
            
            <p>El ESP32 debe analizar el HTML de esta página para determinar el estado de cada LED y actualizar los LEDs físicos en consecuencia.</p>
        </div>
    </div>
    
    <footer>
        <p>Página web para control de LEDs ESP32 - http://127.0.0.1:8000/Control/bombas</p>
    </footer>

    <script>
        // Estado inicial de los LEDs
        let ledStates = {
            1: false,
            2: false,
            3: false,
            4: false
        };
        
        // Función para cambiar el estado de un LED
        function toggleLED(ledNumber, state) {
            ledStates[ledNumber] = state;
            updateLEDDisplay(ledNumber);
            
            // Aquí puedes agregar código para guardar el estado en un servidor
            // o base de datos si es necesario
            console.log(`LED ${ledNumber} cambiado a: ${state ? 'ENCENDIDO' : 'APAGADO'}`);
        }
        
        // Función para actualizar la visualización de un LED
        function updateLEDDisplay(ledNumber) {
            const statusElement = document.getElementById(`status${ledNumber}`);
            const visualElement = document.getElementById(`visual${ledNumber}`);
            
            if (ledStates[ledNumber]) {
                statusElement.textContent = "ENCENDIDO";
                statusElement.className = "status on";
                visualElement.className = "led-visual on";
            } else {
                statusElement.textContent = "APAGADO";
                statusElement.className = "status off";
                visualElement.className = "led-visual off";
            }
        }
        
        // Simular cambios aleatorios para demostración
        setInterval(() => {
            // Solo para demostración - cambiar un LED aleatorio cada 10 segundos
            if (Math.random() > 0.7) {
                const randomLed = Math.floor(Math.random() * 4) + 1;
                toggleLED(randomLed, !ledStates[randomLed]);
            }
        }, 10000);
    </script>
</body>
</html>

@endsection