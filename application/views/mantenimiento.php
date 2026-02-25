<?php
defined('BASEPATH') OR exit('No direct script access allowed');
setlocale(LC_TIME, 'es_CO.UTF-8');
$nombre = strftime("%B",mktime(0, 0, 0, date('m'), 1, 2000));
$fecha = date('d')." de ".$nombre." del ".date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="refresh" content="7200" />
    <meta name="application-name" content="Sistema Integrado de Información de Acreditación - SIIA" />
    <meta name="description" content="Sistema Integrado de Información de Acreditación (SIIA) para entidades con interés de acreditarse en cursos de economía solidaria. Unidad Administrativa Especial de Organizaciones Solidarias." />
    <meta name="keywords" content="Organizaciones Solidarias,Sector Solidario,Cooperativas,Economía solidaria,Empresa,Social,Asociatividad,Emprendimiento,Proyectos productivos,Negocios inclusivos,Productores,Empresarios,Campesinos,Asociativo,Comercio justo,Agro,Ley 454" />
    <meta name="author" content="Unidad Solidaria" />
    <meta name="revisit-after" content="30 days" />
    <meta name="distribution" content="web" />
    <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW" />
    <meta name="theme-color" content="#004884"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="white-translucent" />
    <meta name="google-site-verification" content="DloHloB2_mQ9o7BPTd9xXEYHUeXrnWQqKGGKeuGrkLk" />
    <!-- Google -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WHVM3FM');
    </script>
    <!-- End Google Tag Manager -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-99079478-1', 'auto');
        ga('send', 'pageview');
    </script>
    <title>SIIA - En Mantenimiento</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #004884 0%, #003366 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        
        .logo-item {
            display: flex;
            align-items: center;
        }
        
        .logo-item img {
            height: 50px;
            width: auto;
            filter: brightness(0) invert(1);
        }
        
        .system-info h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        
        .system-info p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
        }
        
        .maintenance-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 800px;
            width: 100%;
            border-top: 4px solid #004884;
        }
        
        .maintenance-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 40px;
            box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);
        }
        
        .maintenance-icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }
        
        .maintenance-title {
            font-size: 36px;
            font-weight: 700;
            color: #004884;
            margin-bottom: 20px;
        }
        
        .maintenance-subtitle {
            font-size: 20px;
            color: #6b7280;
            margin-bottom: 40px;
            font-weight: 400;
        }
        
        .maintenance-message {
            font-size: 18px;
            color: #374151;
            line-height: 1.8;
            margin-bottom: 40px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 30px;
            text-align: left;
        }
        
        .info-card h3 {
            color: #004884;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-card p {
            color: #4b5563;
            margin: 8px 0;
        }
        
        .info-card strong {
            color: #1f2937;
        }
        
        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin: 20px 0;
        }
        
        /* Footer */
        .footer {
            background: #1f2937;
            color: #d1d5db;
            padding: 40px 0;
            text-align: center;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer h4 {
            color: white;
            font-size: 20px;
            margin-bottom: 20px;
        }
        
        .footer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-section h5 {
            color: #004884;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .footer-section p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .footer-section a {
            color: #60a5fa;
            text-decoration: none;
        }
        
        .footer-section a:hover {
            text-decoration: underline;
        }
        
        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 20px;
            font-size: 12px;
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .logo-section {
                flex-direction: column;
                gap: 20px;
            }
            
            .maintenance-card {
                padding: 40px 20px;
                margin: 20px;
            }
            
            .maintenance-title {
                font-size: 28px;
            }
            
            .maintenance-subtitle {
                font-size: 18px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .info-card {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .maintenance-icon {
                width: 100px;
                height: 100px;
            }
            
            .maintenance-icon svg {
                width: 50px;
                height: 50px;
            }
            
            .maintenance-title {
                font-size: 24px;
            }
            
            .maintenance-message {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHVM3FM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <div class="logo-section">
                    <div class="logo-item">
                        <a href="<?php echo PAGINA_WEB ?>" target="_blank">
                            <img src="<?php echo base_url('assets/img/uaeos-logo.png'); ?>" alt="UAEOS">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="<?php echo base_url(); ?>" target="_blank">
                            <img src="<?php echo base_url('assets/img/siia_logo.png'); ?>" alt="SIIA">
                        </a>
                    </div>
                </div>
                <div class="system-info">
                    <h1>Sistema SIIA</h1>
                    <p>Sistema Integrado de Información de Acreditación</p>
                </div>
            </div>
        </header>
        <!-- Main Content -->
        <main class="main-content">
            <div class="maintenance-card">
                <div class="maintenance-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h1 class="maintenance-title">Sistema en Mantenimiento</h1>
                <p class="maintenance-subtitle">Mejorando nuestros servicios para usted</p>
                <div class="status-badge">🔧 Mantenimiento Programado</div>
                <p class="maintenance-message">
                    La Unidad Administrativa Especial de Organizaciones Solidarias informa que el Sistema SIIA se encuentra temporalmente fuera de servicio debido a labores de mantenimiento preventivo y mejoras en la plataforma.
                </p>
                <div class="info-grid">
                    <div class="info-card">
                        <h3>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Período de Mantenimiento
                        </h3>
                        <p><strong>Inicio:</strong> 26 de noviembre de 2024</p>
                        <p><strong>Finalización:</strong> 7 de diciembre de 2024</p>
                        <p><strong>Duración estimada:</strong> 12 días</p>
                    </div>
                    <div class="info-card">
                        <h3>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Reanudación de Servicios
                        </h3>
                        <p><strong>Fecha:</strong> 8 de diciembre de 2024</p>
                        <p><strong>Hora:</strong> 8:00 AM</p>
                        <p>Podrá reanudar el envío de solicitudes y acceder a todos los servicios del sistema.</p>
                    </div>
                </div>
                <p class="maintenance-message">
                    <strong>Agradecemos su comprensión y paciencia.</strong> Estos trabajos nos permitirán ofrecerle un mejor servicio con nuevas funcionalidades y mayor estabilidad.
                </p>
            </div>
        </main>
        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <h4>Unidad Administrativa Especial de Organizaciones Solidarias</h4>
                <div class="footer-info">
                    <div class="footer-section">
                        <h5>Información de Contacto</h5>
                        <p><strong>Dirección:</strong> Carrera 10 No. 15 - 22, Bogotá, D.C.</p>
                        <p><strong>Teléfono:</strong> <a href="tel:0313275252">(57+1) 3275252</a></p>
                        <p><strong>Email:</strong> <a href="mailto:atencion.ciudadano@unidadsolidaria.gov.co">atencion.ciudadano@unidadsolidaria.gov.co</a></p>
                    </div>
                    <div class="footer-section">
                        <h5>Horarios de Atención</h5>
                        <p><strong>Presencial:</strong> Lunes a viernes, 8:00 AM - 5:00 PM</p>
                        <p><strong>Chat web:</strong> Martes y jueves, 9:00 AM - 12:00 PM</p>
                        <p><strong>Línea gratuita:</strong> <a href="tel:018000122020">018000122020</a></p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y'); ?> Unidad Solidaria - Todos los derechos reservados</p>
                    <p>Fecha actual: <?php echo $fecha; ?></p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
<?php exit(); ?>
