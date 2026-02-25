<!-- Template de Correo de contacto -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIIA - Sistema Integrado de Información de Acreditación</title>
    <style>
        /* Reset CSS para clientes de email */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        
        /* Contenedor principal */
        .email-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        @media only screen and (min-width: 1200px) {
            .email-container {
                max-width: 900px;
            }
        }
        
        /* Header con logos */
        .email-header {
            background-color: #004884;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .logos-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .logo-item {
            background: rgba(255, 255, 255, 1);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .logo-item a {
            text-decoration: none;
            display: block;
        }
        
        .logo-item img {
            height: 60px;
            width: auto;
            display: block;
        }
        
        .header-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 8px 0 0 0;
            font-weight: 400;
        }
        
        /* Contenido principal */
        .email-content {
            padding: 40px 30px;
        }
        
        .content-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .content-icon {
            width: 40px;
            height: 40px;
            background: #0071b9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .content-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }
        
        .content-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }
        
        .message-content {
            background: #f8fafc;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #0071b9;
            margin: 25px 0;
        }
        
        .message-content p {
            margin: 0 0 15px 0;
            text-align: justify;
            line-height: 1.7;
            color: #374151;
        }
        
        .message-content p:last-child {
            margin-bottom: 0;
        }
        
        /* Botón de acción */
        .btn-primary {
            display: inline-block;
            background-color: #0071b9;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 113, 185, 0.3);
            border: none;
            cursor: pointer;
            margin: 20px 0;
        }
        
        .btn-primary:hover {
            background-color: #005a94;
        }
        
        /* Footer */
        .email-footer {
            background: #f1f5f9;
            padding: 30px;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .footer-section h4 {
            color: #0071b9;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .footer-section p {
            margin: 6px 0;
            color: #64748b;
            font-size: 14px;
        }
        
        .footer-section a {
            color: #0071b9;
            text-decoration: none;
        }
        
        .footer-section a:hover {
            text-decoration: underline;
        }
        
        .footer-note {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
        }
        
        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 4px;
            }
            
            .email-header {
                padding: 20px 15px;
            }
            
            .logos-container {
                gap: 15px;
            }
            
            .logo-item {
                padding: 10px;
            }
            
            .logo-item img {
                height: 45px;
            }
            
            .header-title {
                font-size: 22px;
            }
            
            .header-subtitle {
                font-size: 14px;
            }
            
            .email-content {
                padding: 25px 20px;
            }
            
            .content-header {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
            
            .content-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .content-title {
                font-size: 20px;
            }
            
            .message-content {
                padding: 20px 15px;
            }
            
            .btn-primary {
                display: block;
                width: 100%;
                padding: 16px;
                font-size: 16px;
            }
            
            .email-footer {
                padding: 20px 15px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
        
        @media only screen and (max-width: 480px) {
            .logos-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .header-title {
                font-size: 20px;
            }
            
            .content-title {
                font-size: 18px;
            }
            
            .message-content {
                padding: 15px;
            }
        }
        
        /* Fixes para clientes específicos */
        @media screen and (max-width: 525px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        
        /* Outlook fixes */
        <!--[if mso]>
        <style type="text/css">
            .email-container {
                width: 800px !important;
            }
        </style>
        <![endif]-->
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logos-container">
                <div class="logo-item">
                    <a href="https://www.unidadsolidaria.gov.co" target="_blank">
                        <img src="<?php echo base_url('assets/img/uaeos-logo.png'); ?>" alt="UAEOS Logo">
                    </a>
                </div>
                <div class="logo-item">
                    <a href="<?php echo base_url(); ?>" target="_blank">
                        <img src="<?php echo base_url('assets/img/siia_logo.png'); ?>" alt="SIIA Logo">
                    </a>
                </div>
            </div>
            <h1 class="header-title">SIIA</h1>
            <p class="header-subtitle">Sistema Integrado de Información de Acreditación</p>
        </div>
        <!-- Contenido -->
        <div class="email-content">
            <div class="content-header">
                <div class="content-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </div>
                <h2 class="content-title">Información del Sistema</h2>
            </div>
            
            <div class="message-content">
                <?php echo $mensaje; ?>
            </div>
            
            <?php if(isset($boton_url) && isset($boton_texto)): ?>
            <div style="text-align: center; margin: 30px 0;">
                <a href="<?php echo $boton_url; ?>" class="btn-primary"><?php echo $boton_texto; ?></a>
            </div>
            <?php endif; ?>
        </div>
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Información de Contacto</h4>
                    <p><strong>Dirección:</strong> Carrera 10 No 15-22, Bogotá, D.C</p>
                    <p><strong>Teléfono:</strong> (57+1) 3275252</p>
                    <p><strong>Email:</strong> <a href="mailto:atencion.ciudadano@unidadsolidaria.gov.co">atencion.ciudadano@unidadsolidaria.gov.co</a></p>
                </div>
                
                <div class="footer-section">
                    <h4>Enlaces Útiles</h4>
                    <p><a href="<?php echo PAGINA_WEB; ?>">Portal UAEOS</a></p>
                    <p><a href="<?php echo base_url(); ?>">Sistema SIIA</a></p>
                    <!-- <p><a href="mailto:camilo.rios@unidadsolidaria.gov.co">Soporte Técnico</a></p> -->
                </div>
            </div>
            <div class="footer-note">
                <p>Este es un mensaje automático del Sistema SIIA. Por favor no responda a este correo.</p>
                <p>&copy; <?php echo date('Y'); ?> Unidad Solidaria - Unidad Administrativa Especial de Organizaciones Solidarias</p>
            </div>
        </div>
    </div>
</body>
</html>
