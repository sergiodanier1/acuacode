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
<button onclick="conectarSerial()">Conectar Puerto Serial</button>
<canvas id="grafica" width="800" height="400"></canvas>

<script>
  let port;
  let reader;
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

  async function conectarSerial() {
    try {
      port = await navigator.serial.requestPort();
      await port.open({ baudRate: 9600 });

      const textDecoder = new TextDecoderStream();
      const readableStreamClosed = port.readable.pipeTo(textDecoder.writable);
      reader = textDecoder.readable.getReader();

      leerSerial();
    } catch (err) {
      console.error("Error al abrir el puerto serial:", err);
    }
  }

  async function leerSerial() {
    let buffer = "";

    while (true) {
      const { value, done } = await reader.read();
      if (done) {
        reader.releaseLock();
        break;
      }

      buffer += value;
      let lineas = buffer.split('\n');

      for (let i = 0; i < lineas.length - 1; i++) {
        try {
          const datos = JSON.parse(lineas[i].trim());
          agregarDatos(datos);
        } catch (e) {
          console.warn("JSON inválido:", lineas[i]);
        }
      }

      buffer = lineas[lineas.length - 1];
    }
  }

  function agregarDatos(datos) {
    const timestamp = new Date().toLocaleTimeString();
    datosSensor.labels.push(timestamp);

    datosSensor.datasets[0].data.push(datos.temperatura);
    datosSensor.datasets[1].data.push(datos.ph);
    datosSensor.datasets[2].data.push(datos.humedad);
    datosSensor.datasets[3].data.push(datos.oxigenacion);

    if (datosSensor.labels.length > valoresMaximos) {
      datosSensor.labels.shift();
      datosSensor.datasets.forEach(dataset => dataset.data.shift());
    }

    myChart.update();
  }
</script>

</body>

@endsection