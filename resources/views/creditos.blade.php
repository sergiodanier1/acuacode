@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créditos de Desarrollo Web</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* ---- Tus estilos originales ---- */
    /* Quitar el marco blanco del layout */
    body, main, .container {
        background: linear-gradient(180deg, #071021 0%, #062033 100%) !important;
        margin: 0;
        padding: 0;
        border: none;
    }

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
    .actuator-btn .icon{width:46px;height:46px;display:flex;align-items:center;justify-content:center}
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
    
    /* ---- Estilos para la página de créditos ---- */
    .credits-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .page-title {
        text-align: center;
        margin-bottom: 10px;
        font-size: 28px;
        background: linear-gradient(90deg, var(--accent), #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-subtitle {
        text-align: center;
        color: var(--muted);
        margin-bottom: 30px;
        font-size: 16px;
    }
    
    .developers-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
    
    .developer-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
        border-radius: 14px;
        padding: 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .developer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(2,6,23,0.8);
    }
    
    .developer-img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--accent);
        margin-bottom: 20px;
    }
    
    .developer-name {
        font-size: 22px;
        margin: 0 0 8px 0;
        color: var(--text);
    }
    
    .developer-role {
        color: var(--accent);
        margin: 0 0 15px 0;
        font-size: 16px;
    }
    
    .developer-info {
        color: var(--muted);
        margin: 5px 0;
        font-size: 14px;
    }
    
    .developer-links {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }
    
    .developer-link {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--accent);
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s;
    }
    
    .developer-link:hover {
        color: #7c3aed;
    }
    
    .technologies-section {
        margin-top: 30px;
    }
    
    .technologies-title {
        text-align: center;
        font-size: 20px;
        margin-bottom: 20px;
        color: var(--text);
    }
    
    .technologies-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    
    .technology-item {
        background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .technology-icon {
        font-size: 30px;
        color: var(--accent);
    }
    
    .technology-name {
        font-size: 14px;
        color: var(--text);
    }
    
    @media (max-width: 768px) {
        .developers-grid {
            grid-template-columns: 1fr;
        }
        
        .technologies-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    </style>
</head>
<body>
    <div class="panel">
        <div class="credits-container">
            <h1 class="page-title">Créditos de Desarrollo Web</h1>
            <p class="page-subtitle">Proyecto desarrollado por estudiantes de Ingeniería Electrónica</p>
            
            <div class="developers-grid">
                <!-- Tarjeta de Jesús -->
                <div class="developer-card">
                    <img src="imagenes/jesus.jfif" alt="Jesús Armando Gómez Garzón" class="developer-img">
                    <h2 class="developer-name">Jesús Armando Gómez Garzón</h2>
                    <p class="developer-role">Estudiante de Ingeniería Electrónica</p>
                    <p class="developer-info">jesus.gomez.garzon@uniautonoma.edu.co</p>
                    <div class="developer-links">
                        <a href="https://www.facebook.com/jesusarmando.gomez.75" target="_blank" class="developer-link">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    </div>
                </div>
                
                <!-- Tarjeta de Sergio -->
                <div class="developer-card">
                    <img src="imagenes/sergio.jpg" alt="Sergio Danier Córdoba Cerón" class="developer-img">
                    <h2 class="developer-name">Sergio Danier Córdoba Cerón</h2>
                    <p class="developer-role">Estudiante de Ingeniería Electrónica</p>
                    <p class="developer-info">sergiodanier@gmail.com</p>
                    <div class="developer-links">
                        <a href="https://www.facebook.com/SergioDanier" target="_blank" class="developer-link">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="technologies-section">
                <h3 class="technologies-title">Tecnologías Utilizadas</h3>
                <div class="technologies-grid">
                    <div class="technology-item">
                        <i class="fab fa-laravel technology-icon"></i>
                        <span class="technology-name">Laravel</span>
                    </div>
                    <div class="technology-item">
                        <i class="fab fa-js technology-icon"></i>
                        <span class="technology-name">JavaScript</span>
                    </div>
                    <div class="technology-item">
                        <i class="fab fa-bootstrap technology-icon"></i>
                        <span class="technology-name">Bootstrap</span>
                    </div>
                    <div class="technology-item">
                        <i class="fab fa-css3-alt technology-icon"></i>
                        <span class="technology-name">CSS3</span>
                    </div>
                </div>
            </div>
            
            <footer>
                <p>© 2023 - Proyecto de Desarrollo Web - Ingeniería Electrónica</p>
            </footer>
        </div>
    </div>
</body>
</html>
@endsection