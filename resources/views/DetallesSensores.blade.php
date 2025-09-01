@extends('layouts.app')

@section('content')
<head>
  <meta charset="UTF-8">
  <title>Monitor de Sensores</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      padding: 20px;
      margin: 0;
      text-align: center;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      margin: 20px;
      cursor: pointer;
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      justify-items: center;
      max-width: 100%;
      margin: 0 auto;
    }

    .grafica-container {
      width: 100%;
      max-width: 500px;
      height: 250px;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
    }

    canvas {
      width: 100% !important;
      height: 100% !important;
    }

    @media (max-width: 1000px) {
      .grid-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<h1>Monitor de Sensores en Tiempo Real</h1>
<button onclick="iniciarSimulacion()">Iniciar Simulación</button>

<div class="grid-container">
  <div class="grafica-container"><canvas id="graficaTemperatura"></canvas></div>
  <div class="grafica-container"><canvas id="graficaPH"></canvas></div>
  <div class="grafica-container"><canvas id="graficaHumedad"></canvas></div>
  <div class="grafica-container"><canvas id="graficaOxigenacion"></canvas></div>
</div>

<script>
  const valoresMaximos = 20;
  const tamañoMuestra = 5;

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

  function crearGrafica(idCanvas, etiqueta, color, datasetRef) {
    const ctx = document.getElementById(idCanvas).getContext('2d');
    return new Chart(ctx, {
      type: 'line',
      data: {
        labels: datos.etiquetas,
        datasets: [{
          label: etiqueta,
          data: datasetRef,
          borderColor: color,
          fill: false
        }]
      },
      options: {
        responsive: true,
        animation: false,
        maintainAspectRatio: false,
        scales: {
          x: {
            title: {
              display: true,
              text: 'Tiempo'
            }
          },
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }

  window.onload = function () {
    graficas.temperatura = crearGrafica("graficaTemperatura", "Temperatura (°C)", "red", datos.temperatura);
    graficas.ph = crearGrafica("graficaPH", "pH", "green", datos.ph);
    graficas.humedad = crearGrafica("graficaHumedad", "Humedad (%)", "blue", datos.humedad);
    graficas.oxigenacion = crearGrafica("graficaOxigenacion", "Oxigenación (mg/L)", "orange", datos.oxigenacion);
  };

  let intervaloSimulacion;

  function iniciarSimulacion() {
    if (intervaloSimulacion) clearInterval(intervaloSimulacion);

    intervaloSimulacion = setInterval(() => {
      const lectura = {
        temperatura: parseFloat((Math.random() * 10 + 20).toFixed(2)), // 20-30 °C
        ph: parseFloat((Math.random() * 2 + 6).toFixed(2)),            // 6-8
        humedad: parseFloat((Math.random() * 50 + 30).toFixed(2)),     // 30-80 %
        oxigenacion: parseFloat((Math.random() * 5 + 4).toFixed(2))    // 4-9 mg/L
      };

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
    }, 1000);
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

    // Actualizar todas las gráficas
    Object.values(graficas).forEach(g => g.update());
  }
</script>

</body>

@endsection
