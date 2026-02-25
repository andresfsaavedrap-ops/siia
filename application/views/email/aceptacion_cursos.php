<!-- Template de Correo de la verificacion de Cuenta -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIIA - Aceptación Metodología: <?php echo 'Curso XXXXXX'?></title>
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
        
        /* Información de la organización */
        .organization-info {
            background: #f8fafc;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #0071b9;
            margin: 25px 0;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #374151;
            display: block;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #6b7280;
            margin: 0;
            padding-left: 10px;
        }
        
        .acceptance-text {
            background: #ecfdf5;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .acceptance-text strong {
            color: #065f46;
            font-size: 16px;
        }
        
        .important-note {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .important-note p {
            margin: 0;
            color: #92400e;
            line-height: 1.6;
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
            
            .organization-info,
            .acceptance-text,
            .important-note {
                padding: 20px 15px;
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
            
            .organization-info,
            .acceptance-text,
            .important-note {
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
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="content-title">Aceptación de Metodología</h2>
            </div>
            
            <div class="organization-info">
                <div class="info-item">
                    <label class="info-label">Nombre de la organización:</label>
                    <p class="info-value"><?php echo $organizacion->nombreOrganizacion; ?></p>
                </div>
                
                <div class="info-item">
                    <label class="info-label">NIT de la organización:</label>
                    <p class="info-value"><?php echo $organizacion->numNIT; ?></p>
                </div>
                
                <div class="info-item">
                    <label class="info-label">Fecha:</label>
                    <p class="info-value"><?php echo $data['fecha']; ?></p>
                </div>
            </div>
            
            <div class="acceptance-text">
                <strong>Acepto desarrollar el Programa de Organizaciones y Redes del SEAS según el anexo técnico de la resolución 078 de 2025.</strong>
            </div>
            
            <div class="important-note">
                <p>La Unidad Solidaria le recuerda que es importante mantener la información básica de contacto de la entidad actualizada, para facilitar el desarrollo del proceso derivado del trámite de acreditación. Le recomendamos realizar los cambios o actualizaciones a través del SIIA. En razón a la política de manejo de datos institucional y para verificar la identidad de la organización, se recomienda conservar su usuario y contraseña.</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Información de Contacto</h4>
                    <p><strong>Dirección:</strong> <a href="https://www.google.com/maps/place/Unidad+Administrativa+Especial+de+Organizaciones+Solidarias/@4.6035029,-74.0778588,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f99a0936dd021:0x79ff772c3f90b782!8m2!3d4.6035029!4d-74.0756701" target="_blank">Carrera 10 No. 15 - 22, Bogotá, D.C</a></p>
                    <p><strong>Teléfono:</strong> <a href="tel:0313275252">(57+1) 3275252</a> Ext. 301</p>
                    <p><strong>Línea gratuita:</strong> <a href="tel:018000122020">018000122020</a></p>
                    <p><strong>Email:</strong> <a href="mailto:<?php echo CORREO_ATENCION ?>"><?php echo CORREO_ATENCION ?></a></p>
                </div>
                
                <div class="footer-section">
                    <h4>Enlaces Útiles</h4>
                    <p><a href="<?php echo PAGINA_WEB; ?>" target="_blank">Portal UAEOS</a></p>
                    <p><a href="<?php echo base_url(); ?>" target="_blank">Sistema SIIA</a></p>
                    <p><a href="<?php echo base_url("assets/manuales/Manual_Usuario.pdf"); ?>" target="_blank">Manual de Usuario</a></p>
                    <p><strong>Chat web:</strong> Martes y jueves de 9 am a 12 pm</p>
                </div>
            </div>
            <div class="footer-note">
                <p>Este es un mensaje automático del Sistema SIIA. Por favor no responda a este correo.</p>
                <p>&copy; <?php echo date('Y'); ?> Unidad Solidaria - Unidad Administrativa Especial de Organizaciones Solidarias</p>
                <p><strong>Horario de atención:</strong> Lunes a viernes de 8:00 a.m. a 5:00 p.m.</p>
            </div>
        </div>
    </div>
</body>
</html>
