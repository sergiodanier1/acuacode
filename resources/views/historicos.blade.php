@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Mensual de Datos Acuapónicos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <style>
    /* ---- Tus estilos originales (no modificados) ---- */
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
    .actuator-btn .icon{Width:46px;height:46px;display:flex;align-items:center;justify-content:center}
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
      grid-template-columns: 1fr 1fr;
      gap: var(--gap);
      margin-top: 20px;
    }
    
    @media (max-width: 900px) {
      .chart-grid {
        grid-template-columns: 1fr;
      }
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
    
    .stats-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: var(--gap);
      margin-top: 20px;
    }
    
    .stat-card {
      background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
      border-radius: 12px;
      padding: 15px;
      display: flex;
      flex-direction: column;
    }
    
    .stat-title {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 8px;
    }
    
    .stat-value {
      font-size: 20px;
      font-weight: 600;
      color: var(--text);
    }
    
    .error-message {
      background: rgba(225, 29, 72, 0.1);
      border: 1px solid rgba(225, 29, 72, 0.3);
      border-radius: 8px;
      padding: 15px;
      margin: 20px 0;
      color: #e6eef8;
    }
    
    .success-message {
      background: rgba(22, 163, 74, 0.1);
      border: 1px solid rgba(22, 163, 74, 0.3);
      border-radius: 8px;
      padding: 15px;
      margin: 20px 0;
      color: #e6eef8;
    }
    
    .month-selector {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    
    .month-btn {
      padding: 8px 12px;
      border-radius: 8px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.06);
      color: var(--muted);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .month-btn.active {
      background: rgba(6, 182, 212, 0.2);
      border-color: var(--accent);
      color: var(--text);
    }
  </style>
</head>
<body>
    <div class="panel">
        <div>
            <h1>Registro Acuapónico Mensual</h1>
            <p class="lead">Monitoreo de variables acuapónicas - Datos cargados desde GitHub</p>
        </div>        
        <div class="data-controls">
            <div class="status-list">
                <div class="dot" style="background:var(--accent)"></div>
                <span id="connectionStatus">Conectando a GitHub...</span>
            </div>
            <button class="btn-light" id="refreshBtn">🔄 Actualizar</button>
        </div>
        
        <div id="messageContainer"></div>
        
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
        
        <div class="stats-container" id="statsContainer">
            <!-- Las estadísticas se insertarán aquí -->
        </div>
        
        <div class="loader" id="mainLoader" style="display:none"></div>
        
        <h2 class="section-title">Evolución y Distribución de Datos</h2>
        
        <div class="chart-grid" id="chartsContainer">
            <!-- Aquí se crearán los canvases para lineas e histogramas -->
        </div>
        
        <h2 class="section-title">Datos en Tabla</h2>
        <div class="chart-card">
            <div class="chart-title">📊 Registro Completo de Datos</div>
            <div style="overflow-x: auto;">
                <table class="data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Etiqueta</th>
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
            <p>Datos cargados desde: https://github.com/sergiodanier1/registro_mensual/blob/main/datos_acuaponico_mensuales_nombres.csv</p>
        </footer>
    </div>

    <script>
    // URL del CSV en GitHub (raw)
    const csvUrl = 'https://raw.githubusercontent.com/sergiodanier1/registro_mensual/main/datos_acuaponico_mensuales_nombres.csv';

    // DOM
    const connectionStatus = document.getElementById('connectionStatus');
    const mainLoader = document.getElementById('mainLoader');
    const messageContainer = document.getElementById('messageContainer');
    const chartsContainer = document.getElementById('chartsContainer');
    const statsContainer = document.getElementById('statsContainer');
    const dataTable = document.getElementById('dataTable');
    const refreshBtn = document.getElementById('refreshBtn');
    const tempValue = document.getElementById('tempValue');
    const humValue = document.getElementById('humValue');
    const phValue = document.getElementById('phValue');
    const oxygenValue = document.getElementById('oxygenValue');

    // Colores
    const chartColors = {
        temperature: 'rgba(255, 99, 132, 0.8)',
        humidity: 'rgba(54, 162, 235, 0.8)',
        ph: 'rgba(255, 206, 86, 0.8)',
        oxygen: 'rgba(75, 192, 192, 0.8)'
    };

    // Guardar instancias de Chart para destruir al refrescar
    const charts = {};

    function showMessage(msg, type='info'){
        messageContainer.innerHTML = `<div class="${type}-message">${msg}</div>`;
    }

    // Encuentra el valor en la fila según substrings (robusto a nombres)
    function findValue(row, substrings){
        for(const key in row){
            const k = key.toString().toLowerCase().replace(/[^a-z0-9]/g,'');
            for(const s of substrings){
                if(k.includes(s)) return row[key];
            }
        }
        return undefined;
    }

    // Extrae un número de un string (maneja '23,07', '8.5 mg/L', '70 %')
    function toNumber(raw){
        if(raw === undefined || raw === null) return null;
        const s = String(raw).trim();
        // Buscar la primera ocurrencia de un número (opcional decimal y signo)
        const m = s.match(/-?\d+([.,]\d+)?/);
        if(!m) return null;
        return parseFloat(m[0].replace(',', '.'));
    }

    // Agrupa/normaliza el CSV en un arreglo de objetos {label,temp,hum,ph,oxy,raw}
    function normalizeData(rows){
        return rows.map(r => {
            // Buscar etiqueta: prefiero 'mes' o 'fecha'
            let label = findValue(r, ['mes','fecha','date','label']) || '';
            // Si la etiqueta es ISO yyyy-mm-dd, podríamos formatear. Por ahora la dejamos tal cual.
            // Buscar valores numéricos con claves probable
            const tempRaw = findValue(r, ['temperatur','temp']);
            const humRaw  = findValue(r, ['humedad','humed']);
            const phRaw   = findValue(r, ['ph']);
            const oxyRaw  = findValue(r, ['oxigen','oxigeno','oxigenodisuelto','oxigenodisuel tom']);
            return {
                label: label,
                temp: toNumber(tempRaw),
                hum: toNumber(humRaw),
                ph: toNumber(phRaw),
                oxy: toNumber(oxyRaw),
                raw: r
            };
        });
    }

    // Calcula estadísticos básicos
    function calcStats(arr){
        const vals = arr.filter(v => v !== null && v !== undefined);
        if(vals.length === 0) return {min:0,max:0,avg:0};
        const min = Math.min(...vals);
        const max = Math.max(...vals);
        const sum = vals.reduce((a,b)=>a+b,0);
        return {min, max, avg: sum / vals.length};
    }

    // Crear gráfica de línea (destruye si ya existe)
    function createLineChart(id, labels, data, label, color){
        const ctx = document.getElementById(id).getContext('2d');
        if(charts[id]) charts[id].destroy();
        charts[id] = new Chart(ctx, {
            type: 'line',
            data: { labels, datasets: [{ label, data, borderColor: color, backgroundColor: color.replace('0.8','0.25'), fill: true, tension: 0.25 }]},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#e6eef8' } }
                },
                scales: {
                    x: { ticks: { color: '#9aa6bd' } },
                    y: { ticks: { color: '#9aa6bd' } }
                }
            }
        });
    }

    // Crear histograma (utiliza bins)
    function createHistogram(id, values, label, color, binsCount = 8){
        const numbers = values.filter(v => v !== null && v !== undefined);
        const ctx = document.getElementById(id).getContext('2d');
        if(charts[id]) charts[id].destroy();

        if(numbers.length === 0){
            // gráfico vacío
            charts[id] = new Chart(ctx, {
                type: 'bar',
                data: { labels: ['sin datos'], datasets: [{ label, data: [0], backgroundColor: color }]},
                options: { responsive: true, maintainAspectRatio: false,
                    plugins:{legend:{display:false}}, scales:{x:{ticks:{color:'#9aa6bd'}}, y:{ticks:{color:'#9aa6bd'}}}
                }
            });
            return;
        }

        const min = Math.min(...numbers);
        const max = Math.max(...numbers);
        const range = max - min || 1;
        const size = range / binsCount;
        const bins = Array.from({length: binsCount}, (_,i) => ({min: min + i*size, max: min + (i+1)*size, count:0}));
        numbers.forEach(v => {
            const idx = Math.min(Math.floor((v - min) / size), binsCount - 1);
            bins[idx].count++;
        });

        charts[id] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bins.map(b => `${b.min.toFixed(1)} - ${b.max.toFixed(1)}`),
                datasets: [{ label, data: bins.map(b => b.count), backgroundColor: color }]
            },
            options: { responsive: true, maintainAspectRatio: false,
                plugins:{legend:{display:false}}, scales:{x:{ticks:{color:'#9aa6bd'}}, y:{ticks:{color:'#9aa6bd'}}}
            }
        });
    }

    // Poblar tabla HTML
    function populateTable(normalized){
        const tbody = dataTable.querySelector('tbody');
        tbody.innerHTML = '';
        normalized.forEach(row => {
            const tr = document.createElement('tr');
            const label = row.label || '-';
            const t = row.temp !== null ? row.temp.toFixed(2) : '--';
            const h = row.hum !== null ? row.hum.toFixed(2) : '--';
            const p = row.ph !== null ? row.ph.toFixed(2) : '--';
            const o = row.oxy !== null ? row.oxy.toFixed(2) : '--';
            tr.innerHTML = `<td>${label}</td><td>${t}</td><td>${h}</td><td>${p}</td><td>${o}</td>`;
            tbody.appendChild(tr);
        });
    }

    // Mostrar tarjetas de stats y valores actuales
    function renderStats(normalized){
        const temps = normalized.map(r => r.temp);
        const hums  = normalized.map(r => r.hum);
        const phs   = normalized.map(r => r.ph);
        const oxys  = normalized.map(r => r.oxy);

        const tStats = calcStats(temps), hStats = calcStats(hums), pStats = calcStats(phs), oStats = calcStats(oxys);

        statsContainer.innerHTML = `
            <div class="stat-card">
                <div class="stat-title">🌡️ Temperatura</div>
                <div class="stat-value">Avg: ${tStats.avg.toFixed(1)}°C</div>
                <div>Min: ${tStats.min.toFixed(1)}°C | Max: ${tStats.max.toFixed(1)}°C</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">💧 Humedad</div>
                <div class="stat-value">Avg: ${hStats.avg.toFixed(1)}%</div>
                <div>Min: ${hStats.min.toFixed(1)}% | Max: ${hStats.max.toFixed(1)}%</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">🧪 pH</div>
                <div class="stat-value">Avg: ${pStats.avg.toFixed(2)}</div>
                <div>Min: ${pStats.min.toFixed(2)} | Max: ${pStats.max.toFixed(2)}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">🌊 Oxígeno Disuelto</div>
                <div class="stat-value">Avg: ${oStats.avg.toFixed(2)} mg/L</div>
                <div>Min: ${oStats.min.toFixed(2)} mg/L | Max: ${oStats.max.toFixed(2)} mg/L</div>
            </div>
        `;

        // Valores actuales: último registro con datos
        const last = [...normalized].reverse().find(r => r.temp!==null||r.hum!==null||r.ph!==null||r.oxy!==null);
        tempValue.textContent = last && last.temp!==null ? `${last.temp.toFixed(1)}°C` : '--°C';
        humValue.textContent  = last && last.hum!==null  ? `${last.hum.toFixed(1)}%` : '--%';
        phValue.textContent   = last && last.ph!==null   ? `${last.ph.toFixed(2)}` : '--';
        oxygenValue.textContent = last && last.oxy!==null ? `${last.oxy.toFixed(2)}mg/L` : '--mg/L';
    }

    // Carga y render principal
    async function initDashboard(){
        connectionStatus.textContent = 'Conectando a GitHub...';
        mainLoader.style.display = 'block';
        messageContainer.innerHTML = '';
        chartsContainer.innerHTML = '';

        try{
            const resp = await fetch(csvUrl);
            if(!resp.ok) throw new Error('HTTP ' + resp.status);
            const csvText = await resp.text();
            const parsed = Papa.parse(csvText, {header:true, skipEmptyLines:true});
            let rows = parsed.data || [];
            if(rows.length === 0) {
                showMessage('No se encontraron registros en el CSV.', 'error');
                mainLoader.style.display = 'none';
                connectionStatus.textContent = 'Conexión fallida';
                return;
            }

            connectionStatus.textContent = 'Conectado a GitHub';
            showMessage(`Datos cargados: ${rows.length} registros.`, 'success');

            // Normalizar (buscar campos)
            const normalized = normalizeData(rows);

            // Etiquetas y series (mantener orden del CSV)
            const labels = normalized.map(r => (r.label && r.label.toString()) || '');
            const temps  = normalized.map(r => r.temp);
            const hums   = normalized.map(r => r.hum);
            const phs    = normalized.map(r => r.ph);
            const oxys   = normalized.map(r => r.oxy);

            // Crear contenedores de gráficas (líneas + histogramas)
            chartsContainer.innerHTML = `
                <div class="chart-card">
                    <div class="chart-title">📈 Temperatura — Evolución</div>
                    <div class="chart-container"><canvas id="tempLine"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📈 Humedad — Evolución</div>
                    <div class="chart-container"><canvas id="humLine"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📈 pH — Evolución</div>
                    <div class="chart-container"><canvas id="phLine"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📈 Oxígeno — Evolución</div>
                    <div class="chart-container"><canvas id="oxyLine"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📊 Temperatura — Distribución (Histograma)</div>
                    <div class="chart-container"><canvas id="tempHist"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📊 Humedad — Distribución (Histograma)</div>
                    <div class="chart-container"><canvas id="humHist"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📊 pH — Distribución (Histograma)</div>
                    <div class="chart-container"><canvas id="phHist"></canvas></div>
                </div>
                <div class="chart-card">
                    <div class="chart-title">📊 Oxígeno — Distribución (Histograma)</div>
                    <div class="chart-container"><canvas id="oxyHist"></canvas></div>
                </div>
            `;

            // Generar líneas
            createLineChart('tempLine', labels, temps, 'Temperatura (°C)', chartColors.temperature);
            createLineChart('humLine', labels, hums, 'Humedad (%)', chartColors.humidity);
            createLineChart('phLine', labels, phs, 'pH', chartColors.ph);
            createLineChart('oxyLine', labels, oxys, 'Oxígeno (mg/L)', chartColors.oxygen);

            // Generar histogramas (usar sólo los valores)
            createHistogram('tempHist', temps, 'Temperatura (°C)', chartColors.temperature, 8);
            createHistogram('humHist', hums, 'Humedad (%)', chartColors.humidity, 8);
            createHistogram('phHist', phs, 'pH', chartColors.ph, 8);
            createHistogram('oxyHist', oxys, 'Oxígeno (mg/L)', chartColors.oxygen, 8);

            // Tabla y estadísticas
            populateTable(normalized);
            renderStats(normalized);
        } catch(err){
            console.error('Error cargando/parseando CSV:', err);
            showMessage('No se pudieron cargar los datos: ' + err.message, 'error');
            connectionStatus.textContent = 'Error de conexión';
        } finally {
            mainLoader.style.display = 'none';
        }
    }

    // Inicializar
    document.addEventListener('DOMContentLoaded', initDashboard);
    refreshBtn.addEventListener('click', initDashboard);
    </script>
</body>
</html>

@endsection