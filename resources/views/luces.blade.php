@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Control de LEDs</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background: #f0f4f8;
      padding: 20px;
    }
    button {
      padding: 15px 30px;
      margin: 10px;
      font-size: 18px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
    .on { background: green; color: white; }
    .off { background: red; color: white; }
  </style>
</head>
<body>
  <h1>Control de 4 LEDs</h1>
  <button class="on" onclick="controlLed(0,1)">Encender LED 1</button>
  <button class="off" onclick="controlLed(0,0)">Apagar LED 1</button><br>
  
  <button class="on" onclick="controlLed(1,1)">Encender LED 2</button>
  <button class="off" onclick="controlLed(1,0)">Apagar LED 2</button><br>
  
  <button class="on" onclick="controlLed(2,1)">Encender LED 3</button>
  <button class="off" onclick="controlLed(2,0)">Apagar LED 3</button><br>
  
  <button class="on" onclick="controlLed(3,1)">Encender LED 4</button>
  <button class="off" onclick="controlLed(3,0)">Apagar LED 4</button>

<script>
  // ⚡ Usa la IP real de tu ESP32
  const ESP_IP = "http://192.168.1.12";

  function controlLed(led, estado) {
    fetch(`${ESP_IP}/led?pin=${led}&state=${estado}`)
      .then(response => response.text())
      .then(data => console.log("Respuesta ESP:", data))
      .catch(error => console.error("Error:", error));
  }
</script>

</body>
</html>

@endsection