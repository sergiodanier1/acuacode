@extends('layouts.app')

@section('content')
<div class="sensores-container">
    <!-- Encabezado de la página -->
    <div class="page-header">
        <h1>Sensores del Sistema Acuapónico</h1>
        <p>Monitoreo integral de todos los parámetros críticos para el óptimo funcionamiento de tu sistema acuapónico</p>
    </div>

    <!-- Resumen estadístico -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-number">12</div>
            <div class="stat-label">Sensores Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">98%</div>
            <div class="stat-label">Eficiencia General</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">3</div>
            <div class="stat-label">Alertas Activas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Monitoreo Continuo</div>
        </div>
    </div>

    <!-- Sensores de Calidad de Agua -->
    <div class="category-section">
        <h2 class="category-title">Sensores de Calidad de Agua</h2>
        <div class="sensor-grid">
            <!-- Sensor de pH -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">🌡️</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de pH</h3>
                    <span class="sensor-type-badge type-water">Agua</span>
                    <span class="sensor-status status-active">Activo</span>
                </div>
                <p class="sensor-description">
                    Mide la acidez o alcalinidad del agua. Fundamental para la salud de peces y plantas.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">0-14 pH</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±0.01 pH</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Tanque principal</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">6.8 pH</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>

            <!-- Sensor de Temperatura -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">🔥</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de Temperatura</h3>
                    <span class="sensor-type-badge type-water">Agua</span>
                    <span class="sensor-status status-active">Activo</span>
                </div>
                <p class="sensor-description">
                    Controla la temperatura del agua para garantizar condiciones óptimas para la vida acuática.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">-10°C a 60°C</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±0.1°C</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Sistema de cultivo</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">24.5°C</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>

            <!-- Sensor de Oxígeno Disuelto -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">💨</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de Oxígeno Disuelto</h3>
                    <span class="sensor-type-badge type-water">Agua</span>
                    <span class="sensor-status status-critical">Crítico</span>
                </div>
                <p class="sensor-description">
                    Mide los niveles de oxígeno en el agua, esencial para la supervivencia de los peces.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">0-20 mg/L</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±0.1 mg/L</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Tanque de peces</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">4.2 mg/L</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sensores de Nutrientes -->
    <div class="category-section">
        <h2 class="category-title">Sensores de Nutrientes y Químicos</h2>
        <div class="sensor-grid">
            <!-- Sensor de Amoníaco -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">⚠️</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de Amoníaco</h3>
                    <span class="sensor-type-badge type-water">Químico</span>
                    <span class="sensor-status status-critical">Alerta</span>
                </div>
                <p class="sensor-description">
                    Detecta niveles de amoníaco, tóxico para los peces en concentraciones elevadas.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">0-10 ppm</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±0.01 ppm</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Filtro biológico</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">0.8 ppm</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>

            <!-- Sensor de Nitratos -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">🌿</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de Nitratos</h3>
                    <span class="sensor-type-badge type-water">Nutriente</span>
                    <span class="sensor-status status-active">Activo</span>
                </div>
                <p class="sensor-description">
                    Monitorea los niveles de nitratos, nutriente esencial para el crecimiento de las plantas.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">0-100 ppm</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±1 ppm</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Camas de cultivo</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">40 ppm</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>

            <!-- Sensor de Conductividad -->
            <div class="sensor-card">
                <div class="sensor-image">
                    <div class="sensor-icon">⚡</div>
                </div>
                <div class="sensor-header">
                    <h3 class="sensor-title">Sensor de Conductividad</h3>
                    <span class="sensor-type-badge type-water">Calidad</span>
                    <span class="sensor-status status-active">Activo</span>
                </div>
                <p class="sensor-description">
                    Mide la conductividad eléctrica del agua, indicador de la concentración de nutrientes.
                </p>
                <div class="sensor-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango:</span>
                        <span class="spec-value">0-2000 μS/cm</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Precisión:</span>
                        <span class="spec-value">±1%</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Ubicación:</span>
                        <span class="spec-value">Sistema principal</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Última lectura:</span>
                        <span class="spec-value">800 μS/cm</span>
                    </div>
                </div>
                <div class="sensor-actions">
                    <button class="btn btn-primary">Ver Datos</button>
                    <button class="btn btn-secondary">Configurar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Quitar el marco blanco del layout */
body, main, .container {
    background: linear-gradient(180deg, #071021 0%, #062033 100%) !important;
    margin: 0;
    padding: 0;
    border: none;
}

.sensores-container {
    min-height: calc(100vh - 60px);
    background: linear-gradient(180deg, #071021 0%, #062033 100%);
    color: #e6eef8;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    font-size: 2.5rem;
    margin: 0 0 10px 0;
    background: linear-gradient(135deg, #06b6d4, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-header p {
    color: #9aa6bd;
    font-size: 1.1rem;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

.stats-overview {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.05), rgba(124, 58, 237, 0.05));
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.03);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 10px 0;
    color: #06b6d4;
}

.stat-label {
    color: #9aa6bd;
    font-size: 0.9rem;
}

.category-section {
    margin-bottom: 50px;
}

.category-title {
    font-size: 1.8rem;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #06b6d4;
    display: inline-block;
    color: #e6eef8;
}

.sensor-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
}

.sensor-card {
    background: rgba(255,255,255,0.02);
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.03);
}

.sensor-card:hover {
    transform: translateY(-2px);
    background: rgba(255,255,255,0.03);
    box-shadow: 0 8px 25px rgba(2,6,23,0.3);
}

.sensor-image {
    width: 100%;
    height: 120px;
    background: linear-gradient(135deg, rgba(6,182,212,0.1), rgba(124,58,237,0.1));
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.sensor-icon {
    font-size: 3rem;
    opacity: 0.8;
}

.sensor-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.sensor-title {
    font-size: 1.2rem;
    margin: 0;
    color: #06b6d4;
    font-weight: 600;
}

.sensor-status {
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-active {
    background: rgba(22, 163, 74, 0.15);
    color: #16a34a;
}

.status-critical {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
}

.sensor-type-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    background: rgba(6, 182, 212, 0.1);
    color: #06b6d4;
}

.sensor-description {
    color: #9aa6bd;
    line-height: 1.5;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

.sensor-specs {
    margin: 15px 0;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    font-size: 0.85rem;
}

.spec-label {
    color: #9aa6bd;
}

.spec-value {
    font-weight: 600;
    color: #e6eef8;
}

.sensor-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    flex: 1;
    font-size: 0.85rem;
}

.btn-primary {
    background: #06b6d4;
    color: white;
}

.btn-secondary {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: #9aa6bd;
}

.btn:hover {
    transform: translateY(-1px);
    opacity: 0.9;
}

@media (max-width: 768px) {
    .sensor-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .sensores-container {
        padding: 15px;
    }
    
    .stat-card {
        padding: 15px;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }
    
    .sensor-actions {
        flex-direction: column;
    }
}
</style>

<script>
    // Funcionalidad para los botones de los sensores
    document.querySelectorAll('.btn-primary').forEach(button => {
        button.addEventListener('click', function() {
            const sensorTitle = this.closest('.sensor-card').querySelector('.sensor-title').textContent;
            alert(`Mostrando datos del sensor: ${sensorTitle}`);
        });
    });

    document.querySelectorAll('.btn-secondary').forEach(button => {
        button.addEventListener('click', function() {
            const sensorTitle = this.closest('.sensor-card').querySelector('.sensor-title').textContent;
            alert(`Abriendo configuración del sensor: ${sensorTitle}`);
        });
    });

    // Simular actualización de datos en tiempo real
    function updateSensorReadings() {
        const readings = [
            { selector: '.sensor-card:nth-child(1) .spec-value:last-child', values: ['6.7 pH', '6.8 pH', '6.9 pH'] },
            { selector: '.sensor-card:nth-child(2) .spec-value:last-child', values: ['24.3°C', '24.5°C', '24.7°C'] },
            { selector: '.sensor-card:nth-child(3) .spec-value:last-child', values: ['4.1 mg/L', '4.2 mg/L', '4.3 mg/L'] }
        ];

        readings.forEach(reading => {
            const element = document.querySelector(reading.selector);
            if (element) {
                const randomValue = reading.values[Math.floor(Math.random() * reading.values.length)];
                element.textContent = randomValue;
            }
        });
    }

    // Actualizar cada 10 segundos
    setInterval(updateSensorReadings, 10000);
</script>
@endsection