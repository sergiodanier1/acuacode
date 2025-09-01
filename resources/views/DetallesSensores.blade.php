@extends('layouts.app')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
      background: #f0f4f8;
    }
    canvas {
      max-width: 800px;
      margin: 20px auto;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h1>Monitor de Sensores en Tiempo Real</h1>
<button onclick="iniciarSimulacion()">Iniciar Simulación</button>
<canvas id="grafica" width="800" height="400"></canvas>

<script>
  const valoresMaximos = 20;

  const datosSensor = {
    labels: [],
    datasets: [
      {
        label: "Temperatura (°C)",
        data: [],
        borderColor: "red",
        fill: false
      },
      {
        label: "pH",
        data: [],
        borderColor: "green",
        fill: false
      },
      {
        label: "Humedad (%)",
        data: [],
        borderColor: "blue",
        fill: false
      },
      {
        label: "Oxigenación (mg/L)",
        data: [],
        borderColor: "orange",
        fill: false
      }
    ]
  };

  const config = {
    type: 'line',
    data: datosSensor,
    options: {
      responsive: true,
      animation: false,
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
  };

  const ctx = document.getElementById('grafica').getContext('2d');
  const myChart = new Chart(ctx, config);

  let intervaloSimulacion;

  function iniciarSimulacion() {
    if (intervaloSimulacion) clearInterval(intervaloSimulacion);

    intervaloSimulacion = setInterval(() => {
      const datos = {
        temperatura: (Math.random() * 10 + 20).toFixed(2), // 20-30 °C
        ph: (Math.random() * 2 + 6).toFixed(2),            // 6-8
        humedad: (Math.random() * 50 + 30).toFixed(2),     // 30-80 %
        oxigenacion: (Math.random() * 5 + 4).toFixed(2)    // 4-9 mg/L
      };

      agregarDatos(datos);
    }, 1000); // cada 1 segundo
  }

  function agregarDatos(datos) {
    const timestamp = new Date().toLocaleTimeString();
    datosSensor.labels.push(timestamp);

    datosSensor.datasets[0].data.push(parseFloat(datos.temperatura));
    datosSensor.datasets[1].data.push(parseFloat(datos.ph));
    datosSensor.datasets[2].data.push(parseFloat(datos.humedad));
    datosSensor.datasets[3].data.push(parseFloat(datos.oxigenacion));

    if (datosSensor.labels.length > valoresMaximos) {
      datosSensor.labels.shift();
      datosSensor.datasets.forEach(dataset => dataset.data.shift());
    }

    myChart.update();
  }
</script>

</body>

@endsection
