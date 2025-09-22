@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Acuapónico</title>
    <style>
        :root {
            --bg: #0f172a;
            --card: #0b1220;
            --text: #e6eef8;
            --accent: #06b6d4;
            --gap: 18px;
            --btn-size: 140px;
            --on-color: #16a34a;
            --off-color: #e11d48;
            --muted: #9aa6bd;
        }
        
        * {
            box-sizing: border-box;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(180deg, #071021 0%, #062033 100%);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px;
        }
        
        .panel {
            width: 960px;
            max-width: 95%;
            background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 8px 30px rgba(2,6,23,0.6);
        }
        
        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }
        
        .logo {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
        }
        
        h1 {
            margin: 0;
            font-size: 18px;
        }
        
        p.lead {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--gap);
            margin-top: 20px;
        }
        
        .card {
            background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
            border-radius: 12px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            min-height: 170px;
            justify-content: center;
        }
        
        .actuator-btn {
            width: var(--btn-size);
            height: var(--btn-size);
            border-radius: 12px;
            border: 3px solid rgba(255,255,255,0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: transform .12s ease, box-shadow .12s ease;
            background: linear-gradient(180deg, rgba(255,255,255,0.012), rgba(255,255,255,0.008));
            color: var(--text);
            box-shadow: 0 6px 20px rgba(2,6,23,0.45);
        }
        
        .actuator-btn:active {
            transform: translateY(2px) scale(.998);
        }
        
        .actuator-btn .icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .actuator-btn .label {
            font-weight: 600;
        }
        
        .actuator-btn .small {
            font-size: 12px;
            color: var(--muted);
        }
        
        .actuator-btn.on {
            background: linear-gradient(180deg, rgba(22,163,74,0.14), rgba(22,163,74,0.06));
            border-color: rgba(22,163,74,0.45);
            box-shadow: 0 10px 30px rgba(16,185,129,0.08);
        }
        
        .actuator-btn.off {
            background: linear-gradient(180deg, rgba(225,29,72,0.08), rgba(225,29,72,0.03));
            border-color: rgba(225,29,72,0.45);
            box-shadow: 0 10px 30px rgba(225,29,72,0.06);
        }
        
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            gap: 12px;
        }
        
        .status-list {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--muted);
        }
        
        .controls {
            margin-top: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-light {
            padding: 10px 12px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.06);
            color: var(--muted);
            cursor: pointer;
        }
        
        footer {
            margin-top: 18px;
            color: var(--muted);
            font-size: 13px;
        }
        
        @media (max-width: 680px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .actuator-btn {
                width: 120px;
                height: 120px;
            }
        }
        
        /* Estilos adicionales para el contenido */
        .metric-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
            border-radius: 12px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-height: 120px;
            justify-content: center;
        }
        
        .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--accent);
        }
        
        .metric-label {
            font-size: 14px;
            color: var(--muted);
        }
        
        .metric-status {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(22, 163, 74, 0.15);
            color: #16a34a;
        }
        
        .metric-status.warning {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }
        
        .metric-status.danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }
        
        .section-title {
            font-size: 16px;
            margin: 24px 0 16px 0;
            color: var(--text);
            font-weight: 600;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--gap);
            margin-bottom: 24px;
        }
        
        .info-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.005));
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .info-card h3 {
            margin-top: 0;
            color: var(--accent);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 10px;
        }
        
        .info-card p {
            line-height: 1.6;
            color: var(--muted);
        }
        
        .btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .activity-list {
            list-style: none;
            padding: 0;
        }
        
        .activity-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .activity-time {
            min-width: 80px;
            color: var(--muted);
        }
        
        @media (max-width: 680px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="panel">

        <!-- Información introductoria -->
        <div class="info-card">
            <h3>¿Qué es la Acuaponía?</h3>
            <p>La acuaponía es un sistema de producción sostenible que combina la acuicultura (cría de peces) con la hidroponía (cultivo de plantas en agua). En este sistema simbiótico, los desechos de los peces proporcionan nutrientes para las plantas, y las plantas ayudan a filtrar y limpiar el agua para los peces.</p>
            <button class="btn">Ver Tutorial</button>
        </div>

        <!-- Sección de métricas principales -->
        <div class="section-title">Métricas Principales</div>
        <div class="stats-grid">
            <div class="metric-card">
                <div class="metric-value">25.0°C</div>
                <div class="metric-label">Temperatura del Agua</div>
                <div class="metric-status">Óptimo</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">6.8</div>
                <div class="metric-label">pH del Agua</div>
                <div class="metric-status warning">Revisar</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">6.2 mg/L</div>
                <div class="metric-label">Oxígeno Disuelto</div>
                <div class="metric-status">Óptimo</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">0.25 ppm</div>
                <div class="metric-label">Nivel de Amoníaco</div>
                <div class="metric-status danger">Alerta</div>
            </div>
        </div>

        <!-- Información sobre parámetros -->
        <div class="info-card">
            <h3>Parámetros Clave del Sistema</h3>
            <p>El éxito de un sistema acuapónico depende del equilibrio de varios parámetros. La temperatura ideal del agua está entre 18-30°C, el pH debe mantenerse entre 6.8-7.2 para un óptimo crecimiento de plantas y peces, y los niveles de amoníaco deben ser mínimos ya que son tóxicos para los peces.</p>
        </div>

        <!-- Sección de controles -->
        <div class="section-title">Estado del Sistema</div>
        <div class="grid">
            <div class="actuator-btn on" id="pump-btn">
                <div class="icon">💧</div>
                <div class="label">Bombas</div>
                <div class="small">Funcionando</div>
            </div>
            <div class="actuator-btn on" id="light-btn">
                <div class="icon">💡</div>
                <div class="label">Iluminación</div>
                <div class="small">85% intensidad</div>
            </div>
            <div class="actuator-btn on" id="aerator-btn">
                <div class="icon">🌀</div>
                <div class="label">Filtros</div>
                <div class="small">Activos</div>
            </div>
            <div class="actuator-btn on" id="feeder-btn">
                <div class="icon">🍽️</div>
                <div class="label">Alimentación</div>
                <div class="small">Programada</div>
            </div>
        </div>

        <div class="controls">
            <button class="btn-light">Ver Detalles</button>
        </div>

        <!-- Información sobre componentes -->
        <div class="info-card">
            <h3>Componentes del Sistema Acuapónico</h3>
            <p>Un sistema acuapónico típico incluye: tanque de peces, bomba de agua, filtro mecánico y biológico, camas de cultivo para plantas, y sistema de aireación. La bomba circula el agua del tanque de peces a las camas de cultivo, donde las plantas absorben los nutrientes y filtran el agua antes de regresar al tanque.</p>
        </div>

        <!-- Próximas tareas -->
        <div class="section-title">Próximas Tareas</div>
        <div class="info-card">
            <p>• Revisar niveles de nutrientes (en 2 días)</p>
            <p>• Limpieza de filtros (en 5 días)</p>
            <p>• Cosecha de lechugas (en 10 días)</p>
            <p>• Revisión general del sistema (en 14 días)</p>
            <button class="btn">Programar Tarea</button>
        </div>

        <!-- Alertas recientes -->
        <div class="section-title">Alertas Recientes</div>
        <div class="info-card">
            <p>• Nivel de amoníaco elevado</p>
            <p>• Temperatura fluctuante</p>
            <p>• Bajo nivel de agua en tanque</p>
            <button class="btn-light">Ver Todas las Alertas</button>
        </div>

        <!-- Beneficios de la acuaponía -->
        <div class="info-card">
            <h3>Beneficios de la Acuaponía</h3>
            <p>La acuaponía ofrece múltiples ventajas: uso eficiente del agua (hasta 90% menos que la agricultura tradicional), producción de alimentos orgánicos sin pesticidas, sistema cerrado que minimiza los desechos, y posibilidad de implementación en espacios urbanos reducidos.</p>
        </div>

        <!-- Actividad reciente -->
        <div class="section-title">Actividad Reciente</div>
        <div class="info-card">
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-time">10:30 AM</div>
                    <div>Sistema de alimentación activado</div>
                </li>
                <li class="activity-item">
                    <div class="activity-time">09:15 AM</div>
                    <div>Ajuste de pH realizado automáticamente</div>
                </li>
                <li class="activity-item">
                    <div class="activity-time">08:00 AM</div>
                    <div>Reporte diario generado</div>
                </li>
                <li class="activity-item">
                    <div class="activity-time">07:45 AM</div>
                    <div>Iluminación incrementada al 100%</div>
                </li>
                <li class="activity-item">
                    <div class="activity-time">06:30 AM</div>
                    <div>Monitoreo de parámetros completado</div>
                </li>
            </ul>
        </div>

        <!-- Estado del sistema -->
        <div class="status-row">
            <div>Estado del Sistema:</div>
            <div class="status-list">
                <div class="dot" style="background:#16a34a"></div>
                <span>Operativo</span>
                <div class="dot" style="background:#f59e0b"></div>
                <span>Advertencias</span>
                <div class="dot" style="background:#ef4444"></div>
                <span>Alertas</span>
            </div>
        </div>

        <footer>
            Sistema Acuapónico v2.1 • Última actualización: Hoy 14:30
        </footer>
    </div>

    <script>
        // Funcionalidad para los botones de control
        document.querySelectorAll('.actuator-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const isOn = this.classList.contains('on');
                
                if (isOn) {
                    this.classList.remove('on');
                    this.classList.add('off');
                    this.querySelector('.small').textContent = 'Desactivado';
                } else {
                    this.classList.remove('off');
                    this.classList.add('on');
                    
                    // Texto específico para cada botón
                    const label = this.querySelector('.label').textContent;
                    if (label === 'Bombas') {
                        this.querySelector('.small').textContent = 'Funcionando';
                    } else if (label === 'Iluminación') {
                        this.querySelector('.small').textContent = '85% intensidad';
                    } else if (label === 'Filtros') {
                        this.querySelector('.small').textContent = 'Activos';
                    } else if (label === 'Alimentación') {
                        this.querySelector('.small').textContent = 'Programada';
                    }
                }
            });
        });

        // Simulación de actualización de datos en tiempo real
        function updateMetrics() {
            const tempValue = document.querySelector('.stats-grid .metric-card:nth-child(1) .metric-value');
            const phValue = document.querySelector('.stats-grid .metric-card:nth-child(2) .metric-value');
            
            // Simular pequeñas variaciones en los valores
            const currentTemp = parseFloat(tempValue.textContent);
            const currentPh = parseFloat(phValue.textContent);
            
            // Actualizar con pequeñas variaciones (simulación)
            tempValue.textContent = (currentTemp + (Math.random() * 0.4 - 0.2)).toFixed(1) + '°C';
            phValue.textContent = (currentPh + (Math.random() * 0.1 - 0.05)).toFixed(1);
            
            // Actualizar la hora de última actualización
            const now = new Date();
            document.querySelector('footer').textContent = 
                `Sistema Acuapónico v2.1 • Última actualización: ${now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
        }
        
        // Actualizar cada 5 segundos
        setInterval(updateMetrics, 5000);
        
        // Funcionalidad para los botones
        document.querySelector('.btn').addEventListener('click', function() {
            alert('Tutorial del sistema acuapónico abierto');
        });
    </script>
</body>
</html>

@endsection