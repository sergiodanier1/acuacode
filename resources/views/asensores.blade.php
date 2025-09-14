@extends('layouts.app')

@section('content')
    <!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Panel Acuapónico - Control de Actuadores</title>
  <style>
    :root{
      --bg:#0f172a;
      --card:#0b1220;
      --text:#e6eef8;
      --accent:#06b6d4;
      --gap:18px;
      --btn-size:140px;
      --on-color:#16a34a; /* verde */
      --off-color:#e11d48; /* rojo */
      --muted:#9aa6bd;
    }
    *{box-sizing:border-box;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial}
    body{
      margin:0;min-height:100vh;background:linear-gradient(180deg,#071021 0%, #062033 100%);color:var(--text);display:flex;align-items:center;justify-content:center;padding:36px;
    }
    .panel{
      width:960px;max-width:95%;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border-radius:14px;padding:26px;box-shadow:0 8px 30px rgba(2,6,23,0.6);
    }
    .header{display:flex;align-items:center;gap:16px;margin-bottom:18px}
    .logo{width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,var(--accent),#7c3aed);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px}
    h1{margin:0;font-size:18px}
    p.lead{margin:0;color:var(--muted);font-size:13px}

    .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:var(--gap);margin-top:20px}

    .card{background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));border-radius:12px;padding:16px;display:flex;flex-direction:column;align-items:center;gap:12px;min-height:170px;justify-content:center}

    .actuator-btn{
      width:var(--btn-size);height:var(--btn-size);border-radius:12px;border:3px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;cursor:pointer;transition:transform .12s ease, box-shadow .12s ease;
      background:linear-gradient(180deg, rgba(255,255,255,0.012), rgba(255,255,255,0.008));
      color:var(--text);
      box-shadow:0 6px 20px rgba(2,6,23,0.45)
    }
    .actuator-btn:active{transform:translateY(2px) scale(.998)}

    .actuator-btn .icon{width:46px;height:46px;display:flex;align-items:center;justify-content:center}
    .actuator-btn .label{font-weight:600}
    .actuator-btn .small{font-size:12px;color:var(--muted)}

    /* states */
    .actuator-btn.on{background:linear-gradient(180deg, rgba(22,163,74,0.14), rgba(22,163,74,0.06));border-color:rgba(22,163,74,0.45);box-shadow:0 10px 30px rgba(16,185,129,0.08)}
    .actuator-btn.off{background:linear-gradient(180deg, rgba(225,29,72,0.08), rgba(225,29,72,0.03));border-color:rgba(225,29,72,0.45);box-shadow:0 10px 30px rgba(225,29,72,0.06)}

    .status-row{display:flex;align-items:center;justify-content:space-between;margin-top:18px;gap:12px}
    .status-list{display:flex;gap:12px;align-items:center}
    .dot{width:10px;height:10px;border-radius:50%;background:var(--muted)}

    .controls{margin-top:18px;display:flex;align-items:center;gap:10px}
    .btn-light{padding:10px 12px;border-radius:8px;background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted);cursor:pointer}

    footer{margin-top:18px;color:var(--muted);font-size:13px}

    /* responsive */
    @media (max-width:680px){
      .grid{grid-template-columns:repeat(2,1fr)}
      .actuator-btn{width:120px;height:120px}
    }
  </style>
</head>
<body>
  <div class="panel" role="application" aria-label="Panel de control acuapónico">
    <div class="header">
      <div class="logo">AQ</div>
      <div>
        <h1>Panel de control - Sistema acuapónico</h1>
        <p class="lead">Presiona los botones para encender/apagar los actuadores. Verde = encendido, rojo = apagado. El estado se guarda localmente.</p>
      </div>
    </div>

    <div class="grid" id="actuators">
      <!-- Botones: Luz, Dispensador, Válvula, Aereador (bomba) -->
      <div class="card">
        <button class="actuator-btn" data-id="lights" aria-pressed="false">
          <div class="icon" aria-hidden="true"> 
            <!-- bombilla -->
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 21h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 17h7a1 1 0 0 0 .79-1.62A6 6 0 1 0 7.71 15.38 1 1 0 0 0 8.5 17z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="label">Luces</div>
          <div class="small">Estado: <span class="state-text">OFF</span></div>
        </button>
      </div>

      <div class="card">
        <button class="actuator-btn" data-id="dispenser" aria-pressed="false">
          <div class="icon" aria-hidden="true"> 
            <!-- dispensador -->
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7h16v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 10h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="label">Dispensador</div>
          <div class="small">Estado: <span class="state-text">OFF</span></div>
        </button>
      </div>

      <div class="card">
        <button class="actuator-btn" data-id="valve" aria-pressed="false">
          <div class="icon" aria-hidden="true"> 
            <!-- valvula -->
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12h6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 12h6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.2"/></svg>
          </div>
          <div class="label">Válvula</div>
          <div class="small">Estado: <span class="state-text">OFF</span></div>
        </button>
      </div>

      <div class="card">
        <button class="actuator-btn" data-id="aerator" aria-pressed="false">
          <div class="icon" aria-hidden="true"> 
            <!-- bomba/aerador -->
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2v6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 21a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div class="label">Aereador</div>
          <div class="small">Estado: <span class="state-text">OFF</span></div>
        </button>
      </div>

    </div>

    <div class="status-row">
      <div class="status-list">
        <div class="dot" id="dot-lights"></div>
        <div class="dot" id="dot-dispenser"></div>
        <div class="dot" id="dot-valve"></div>
        <div class="dot" id="dot-aerator"></div>
        <div style="margin-left:8px;color:var(--muted);font-size:13px">Indicadores: Luces • Dispensador • Válvula • Aereador</div>
      </div>
      <div class="controls">
        <button class="btn-light" id="all-on">Encender todos</button>
        <button class="btn-light" id="all-off">Apagar todos</button>
        <button class="btn-light" id="reset">Restablecer</button>
      </div>
    </div>

    <footer>Nota: Este panel es una simulación UI. Integra con tu backend/PLC/ESP32 enviando peticiones a la API cuando ocurra el toggle.</footer>
  </div>

  <script>
    // Lista de actuadores y estados por defecto
    const defaultState = {lights:false,dispenser:false,valve:false,aerator:false};
    const storageKey = 'aq_actuator_states_v1';

    function loadState(){
      try{
        const raw = localStorage.getItem(storageKey);
        if(!raw) return {...defaultState};
        return Object.assign({}, defaultState, JSON.parse(raw));
      }catch(e){console.warn('No se pudo leer estado:',e);return {...defaultState}}
    }
    function saveState(state){
      try{localStorage.setItem(storageKey, JSON.stringify(state))}catch(e){console.warn('No se pudo guardar estado:',e)}
    }

    const state = loadState();

    function updateUI(){
      document.querySelectorAll('.actuator-btn').forEach(btn=>{
        const id = btn.dataset.id;
        const isOn = Boolean(state[id]);
        btn.classList.toggle('on', isOn);
        btn.classList.toggle('off', !isOn);
        btn.setAttribute('aria-pressed', String(isOn));
        const txt = btn.querySelector('.state-text');
        if(txt) txt.textContent = isOn ? 'ON' : 'OFF';

        // cambiar color del icono y bordes via estilo inline (accesible)
        const dot = document.getElementById('dot-'+id);
        if(dot) dot.style.background = isOn ? getComputedStyle(document.documentElement).getPropertyValue('--on-color') : getComputedStyle(document.documentElement).getPropertyValue('--muted');
      })
    }

    function toggle(id){
      state[id] = !state[id];
      saveState(state);
      updateUI();

      // Simulación: aqui puedes llamar a fetch('/api/actuator/'+id, {method:'POST', body: JSON.stringify({on: state[id]})})
      console.log('Toggle',id,'->',state[id]);
    }

    document.addEventListener('DOMContentLoaded', ()=>{
      updateUI();

      document.querySelectorAll('.actuator-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const id = btn.dataset.id;
          toggle(id);
        });

        // accesibilidad: toggle con tecla Enter / Space
        btn.addEventListener('keydown', (e)=>{
          if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); btn.click(); }
        });
      });

      document.getElementById('all-on').addEventListener('click', ()=>{
        Object.keys(state).forEach(k=> state[k]=true);
        saveState(state); updateUI();
      });
      document.getElementById('all-off').addEventListener('click', ()=>{
        Object.keys(state).forEach(k=> state[k]=false);
        saveState(state); updateUI();
      });
      document.getElementById('reset').addEventListener('click', ()=>{
        localStorage.removeItem(storageKey);
        Object.assign(state, defaultState);
        updateUI();
      });

    });
  </script>
</body>
</html>

@endsection
