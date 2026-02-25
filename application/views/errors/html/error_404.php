<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
    <meta name="theme-color" content="#004884" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="white-translucent" />
    <meta name="google-site-verification" content="DloHloB2_mQ9o7BPTd9xXEYHUeXrnWQqKGGKeuGrkLk" />
    <!-- Google -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WHVM3FM');
    </script>
    <!-- End Google Tag Manager -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-99079478-1', 'auto');
        ga('send', 'pageview');
    </script>
    <title>404 - Página no encontrada | SIIA</title>
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
        
        .error-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 700px;
            width: 100%;
            border-top: 4px solid #dc2626;
        }
        
        .error-illustration {
            width: 200px;
            height: 200px;
            margin: 0 auto 40px;
            position: relative;
        }
        
        .error-number {
            font-size: 120px;
            font-weight: 900;
            color: #dc2626;
            line-height: 1;
            text-shadow: 2px 2px 4px rgba(220, 38, 38, 0.2);
        }
        
        .error-title {
            font-size: 32px;
            font-weight: 700;
            color: #004884;
            margin-bottom: 20px;
        }
        
        .error-subtitle {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 40px;
            font-weight: 400;
        }
        
        .error-message {
            font-size: 16px;
            color: #374151;
            line-height: 1.8;
            margin-bottom: 40px;
        }
        
        .error-details {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        
        .error-details h3 {
            color: #dc2626;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .error-details ul {
            list-style: none;
            padding: 0;
        }
        
        .error-details li {
            color: #7f1d1d;
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        
        .error-details li:before {
            content: "•";
            color: #dc2626;
            position: absolute;
            left: 0;
        }
        
        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #004884, #003366);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #003366, #002244);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 72, 132, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
            color: #1f2937;
            text-decoration: none;
        }
        
        .help-section {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        
        .help-section h3 {
            color: #004884;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .help-section p {
            color: #1e40af;
            margin: 8px 0;
        }
        
        .help-section a {
            color: #2563eb;
            text-decoration: none;
        }
        
        .help-section a:hover {
            text-decoration: underline;
        }
        
        /* Footer */
        .footer {
            background: #1f2937;
            color: #d1d5db;
            padding: 30px 0;
            text-align: center;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .footer a {
            color: #60a5fa;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
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
            
            .error-card {
                padding: 40px 20px;
                margin: 20px;
            }
            
            .error-number {
                font-size: 80px;
            }
            
            .error-title {
                font-size: 24px;
            }
            
            .error-subtitle {
                font-size: 16px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .error-illustration {
                width: 150px;
                height: 150px;
            }
            
            .error-number {
                font-size: 60px;
            }
            
            .error-title {
                font-size: 20px;
            }
            
            .error-message {
                font-size: 14px;
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
                        <a href="https://www.unidadsolidaria.gov.co" target="_blank">
                            <img src="https://acreditacion.unidadsolidaria.gov.co/siia/assets/img/uaeos-logo.png" alt="UAEOS">
                        </a>
                    </div>
                    <div class="logo-item">
                        <a href="http://acreditacion.unidadsolidaria.gov.co/" target="_blank">
                            <img src="https://acreditacion.unidadsolidaria.gov.co/siia/assets/img/siia_logo.png" alt="SIIA">
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
            <div class="error-card">
                <div class="error-illustration">
                    <div class="error-number">404</div>
                </div>
                
                <h1 class="error-title">Página no encontrada</h1>
                <p class="error-subtitle">La página que busca no existe o ha sido movida</p>
                
                <p class="error-message">
                    Lo sentimos, no pudimos encontrar la página que está buscando. Es posible que la URL sea incorrecta o que la página haya sido eliminada o movida a otra ubicación.
                </p>
                
                <div class="error-details">
                    <h3>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        Posibles causas:
                    </h3>
                    <ul>
                        <li>La URL fue escrita incorrectamente</li>
                        <li>El enlace que siguió está desactualizado</li>
                        <li>La página fue movida o eliminada</li>
                        <li>No tiene permisos para acceder a esta página</li>
                    </ul>
                </div>
                
                <div class="action-buttons">
                    <a href="https://acreditacion.unidadsolidaria.gov.co/" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                        Ir al Inicio
                    </a>
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                        Volver Atrás
                    </a>
                </div>
                
                <div class="help-section">
                    <h3>¿Necesita ayuda?</h3>
                    <p><strong>Soporte técnico:</strong> <a href="mailto:atencion.ciudadano@unidadsolidaria.gov.co">atencion.ciudadano@unidadsolidaria.gov.co</a></p>
                    <p><strong>Teléfono:</strong> <a href="tel:0313275252">(57+1) 3275252</a></p>
                    <p><strong>Horario:</strong> Lunes a viernes, 8:00 AM - 5:00 PM</p>
                </div>
                
                <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
                    <em>Este incidente ha sido reportado automáticamente al equipo técnico.</em>
                </p>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <p><strong>Unidad Administrativa Especial de Organizaciones Solidarias</strong></p>
                <p>Carrera 10 No. 15 - 22, Bogotá, D.C. | <a href="tel:0313275252">(57+1) 3275252</a></p>
                <p>&copy; <?php echo date('Y'); ?> Unidad Solidaria - Todos los derechos reservados</p>
            </div>
        </footer>
    </div>
</body>
</html>
