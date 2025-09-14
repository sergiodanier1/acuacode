@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Sistema de Alertas - Acuapónico</title>
  <style>
    :root {
      --ok:#16a34a;
      --warn:#f59e0b;
      --alert:#e11d48;
      --info:#06b6d4;
      --bg:#0f172a;
      --card:#0b1220;
      --text:#e6eef8;
    }
    body {
      margin:0;
      font-family:sans-serif;
      background:var(--bg);
      color:var(--text);
      display:flex;
      justify-content:center;
      align-items:flex-start;
      padding:30px;
    }
    .panel {
      width:900px;
      max-width:95%;
      background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      border-radius:12px;
      padding:20px;
      box-shadow:0 8px 30px rgba(2,6,23,0.6);
    }
    h1 {
      margin-top:0;
      font-size:20px;
    }
    .alerts {
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
      gap:16px;
      margin-top:20px;
    }
    .alert {
      border-radius:10px;
      padding:14px;
      display:flex;
      flex-direction:column;
      gap:6px;
      box-shadow:0 4px 14px rgba(0,0,0,0.4);
      transition:transform .15s;
    }
    .alert:hover { transform:scale(1.02); }
    .alert h3 { margin:0; font-size:16px; }
    .alert p { margin:0; font-size:13px; }
    .ok { background:rgba(22,163,74,0.15); border-left:6px solid var(--ok);}
    .warn { background:rgba(245,158,11,0.15); border-left:6px solid var(--warn);}
    .alert-critical { background:rgba(225,29,72,0.15); border-left:6px solid var(--alert);}
    .info { background:rgba(6,182,212,0.15); border-left:6px solid var(--info);}
    footer {
      margin-top:18px;
      font-size:12px;
      color:#9aa6bd;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h1>⚠️ Sistema de Alertas - Acuapónico</h1>
    <p>Las alertas cambian de color según el nivel de riesgo detectado.</p>

    <div class="alerts" id="alerts-container">
      <!-- Las alertas se insertan aquí -->
    </div>

    <footer>Este panel de alertas es una simulación. Integra tus sensores (pH, oxígeno, temperatura, etc.) y actualiza dinámicamente el estado.</footer>
  </div>

  <script>
    // Ejemplo de datos de alertas (normalmente vendrían de sensores)
    const sampleAlerts = [
      {type:'ok', title:'Oxígeno disuelto', msg:'Nivel óptimo: 7.8 mg/L'},
      {type:'warn', title:'Temperatura del agua', msg:'Cercana al límite: 29°C'},
      {type:'alert-critical', title:'Nivel de Amoníaco', msg:'Exceso detectado: 1.5 mg/L'},
      {type:'info', title:'Mantenimiento', msg:'Revisión de filtros programada para mañana'},
    ];

    function renderAlerts(){
      const container = document.getElementById('alerts-container');
      container.innerHTML = '';
      sampleAlerts.forEach(a=>{
        const div = document.createElement('div');
        div.className = 'alert '+a.type;
        div.innerHTML = `<h3>${a.title}</h3><p>${a.msg}</p>`;
        container.appendChild(div);
      });
    }
    document.addEventListener('DOMContentLoaded', renderAlerts);
  </script>
</body>
</html>

@endsection 