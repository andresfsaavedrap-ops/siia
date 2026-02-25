<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - SIIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: #004884;
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        
        .template-card {
            margin-bottom: 20px;
        }
        
        .template-card .card-body {
            padding: 25px;
        }
        
        .btn-preview {
            background-color: #004884;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
        }
        
        .btn-preview:hover {
            background-color: #005a94;
            color: white;
        }
        
        .template-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .badge-file {
            background: #e3f2fd;
            color: #004884;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0"><i class="fas fa-envelope me-3"></i><?php echo $title; ?></h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach($templates as $template): ?>
                            <div class="col-md-6">
                                <div class="card template-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $template['name']; ?></h5>
                                        <div class="template-info">
                                            <p class="card-text mb-2"><?php echo $template['description']; ?></p>
                                            <small class="text-muted">
                                                <i class="fas fa-file-code me-1"></i>
                                                <span class="badge badge-file"><?php echo $template['file']; ?></span>
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo $template['url']; ?>" 
                                               class="btn btn-primary btn-sm"
                                               target="_blank">
                                                <i class="fas fa-eye me-2"></i>
                                                Vista Previa
                                            </a>
                                            <a href="<?php echo $template['url']; ?>?download=1" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-download me-2"></i>
                                                Ver HTML
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Información</h6>
                                    <ul class="mb-0">
                                        <li>Los templates utilizan datos de ejemplo para la vista previa</li>
                                        <li>El diseño es completamente responsive y compatible con clientes de email</li>
                                        <li>Los enlaces de los logos redirigen a las páginas oficiales</li>
                                        <li>Para usar estos templates en producción, modifique los datos según sea necesario</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <a href="<?php echo base_url(); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver al Sistema
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
