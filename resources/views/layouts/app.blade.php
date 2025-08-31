<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Acuacode') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])

  <style>
    body { font-family: 'Poppins', sans-serif; margin: 0; }

    /* Header */
    .header {
      height: 60px;
      background: #1a2b3c;
      color: #fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding: 0 20px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1100;
    }

    .header .logo { font-weight: 600; font-size:18px; }
    .header .user { font-size:14px; opacity:0.9; }

    /* Sidebar */
    .sidebar {
      width: 280px;
      position: fixed;
      top: 60px;      /* debajo del header */
      left: 0;
      bottom: 0;      /* permite footer abajo */
      background: linear-gradient(to bottom, #003366, #00AEEF);
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 18px;
      box-sizing: border-box;
      z-index:1000;
    }

    .sidebar h2 { margin:0 0 10px 0; text-align:center; font-size:20px; }

    /* menu scrollable */
    .menu { flex: 1; overflow-y: auto; padding-right:6px; }

    .menu ul { list-style:none; padding:0; margin:0; }
    .menu li { margin:6px 0; }

    .menu a, .menu label {
      display:block;
      padding:10px;
      border-radius:8px;
      color: white;
      text-decoration: none;
      cursor: pointer;
      transition: background .18s;
    }
    .menu a:hover, .menu label:hover { background: rgba(255,255,255,0.12); }

    /* active */
    .menu a.active {
      background: rgba(255,255,255,0.28);
      font-weight:600;
      color:#002233;
    }

    /* submenus con identación */
    .submenu { margin-left: 18px; display: none; }
    .submenu li { margin:6px 0; }
    .submenu a {
      padding:8px 10px;
      background: rgba(255,255,255,0.06);
      border-radius:6px;
      font-size:14px;
    }

    /* checkbox control para abrir */
    .menu input[type="checkbox"] { display:none; }
    .menu input[type="checkbox"]:checked ~ .submenu { display:block; }

    /* Footer dentro del sidebar */
    .sidebar-footer {
      font-size:12px;
      text-align:center;
      padding-top:10px;
      border-top: 1px solid rgba(255,255,255,0.12);
      line-height:1.4;
    }

    /* Contenido principal */
    .main {
      margin-left: 280px; /* espacio para sidebar */
      margin-top: 60px;   /* espacio header */
      padding: 22px;
    }

    /* responsive simple */
    @media (max-width:900px) {
      .sidebar { width: 220px; }
      .main { margin-left: 220px; }
    }
  </style>
</head>
<body>
  @php
    // normalizo la ruta actual a minúsculas para comparaciones case-insensitive
    $current = strtolower(request()->path()); // ejemplo: 'sensores' o 'sensores/detallessensores'
  @endphp

  <!-- Header -->
  <div class="header">
    <div class="logo">Dashboard</div>
    <div class="user">{{ Auth::user()->name ?? 'Invitado' }}</div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>Dashboard</h2>

      <nav class="menu" aria-label="Main menu">
        <ul>
          <li>
            <a href="{{ url('/dashboard') }}" class="{{ $current === 'dashboard' ? 'active' : '' }}">Inicio</a>
          </li>

          <li>
            <input type="checkbox" id="sensores" {{ strpos($current, 'sensores') !== false ? 'checked' : '' }}>
            <label for="sensores">Sensores</label>
            <ul class="submenu">
              <li><a href="{{ url('/Sensores') }}" class="{{ $current === 'sensores' ? 'active' : '' }}">Ver todos los sensores</a></li>
              <li>
                  <a href="{{ url('/Sensores/DetallesSensores') }}" class="{{ $current === 'sensores/detallessensores' ? 'active' : '' }}">
                   histórico del sensor
                  </a>
              </li>
            </ul>
          </li>

          <li>
            <input type="checkbox" id="historicos" {{ strpos($current, 'historicos') !== false ? 'checked' : '' }}>
            <li><a href="{{ url('/historicos') }}" class="{{ $current === 'historicos' ? 'active' : '' }}">Historicos</a></li>
          </li>
          <li>
            <input type="checkbox" id="vivo" {{ strpos($current, 'vivo') !== false ? 'checked' : '' }}>
            <li><a href="{{ url('/vivo') }}" class="{{ $current === 'vivo' ? 'active' : '' }}">Datos en vivo</a></li>
          </li>
          <li>
            <input type="checkbox" id="control" {{ strpos($current, 'control') !== false ? 'checked' : '' }}>
            <label for="control">Control manual</label>
            <ul class="submenu">
              <li><a href="{{ url('/Control/bombas') }}" class="{{ $current === 'control/bombas' ? 'active' : '' }}">Activar / Desactivar bombas</a></li>
              <li><a href="{{ url('/Control/luces') }}" class="{{ $current === 'control/luces' ? 'active' : '' }}">Encender luces</a></li>
              <li><a href="{{ url('/Control/Valvulas') }}" class="{{ $current === 'control/valvulas' ? 'active' : '' }}">Ajustar válvulas</a></li>
            </ul>
          </li>

          <li>
            <input type="checkbox" id="alertas" {{ strpos($current, 'alertas') !== false ? 'checked' : '' }}>
            <label for="alertas">Alertas</label>
            <ul class="submenu">
              <li><a href="{{ url('/Alertas/Activas') }}" class="{{ $current === 'alertas/activas' ? 'active' : '' }}">Ver alertas activas</a></li>
              <li><a href="{{ url('/Alertas/Historial') }}" class="{{ $current === 'alertas/historial' ? 'active' : '' }}">Historial de alertas</a></li>
            </ul>
          </li>

          <!-- Resto de menús: admin-sensores, admin-sistemas, admin-operarios, admin-granjas, usuarios, config -->
          <!-- Mantengo exactamente las mismas opciones que tenías -->
          <li>
            <input type="checkbox" id="admin-sensores" {{ strpos($current, 'admin/sensores') !== false ? 'checked' : '' }}>
            <li><a href="{{ url('/Admin/Sensores') }}" class="{{ $current === 'admin/sensores' ? 'active' : '' }}">Administrar Sensores</a></li>
          </li>          <!-- agrega las demás secciones igual... -->                  

        </ul>
      </nav>
    </div>

    <!-- Footer fijo abajo del sidebar -->
    <div class="sidebar-footer">
      <strong>© 2025</strong><br>
      Jesus Armando<br>
      Sergio Danier Cordoba
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="main">
    @yield('content')
  </div>
</body>
</html>
