<script src="<?= base_url('assets/js/functions/admin/operaciones/cambiar-contrasena.js?v=1.5.1') . time() ?>" type="module"></script>
<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-cog text-primary mr-2"></i>
                            Configuración del Sistema
                        </h4>
                        <p class="text-muted mb-0 small">Personalización de elementos visuales y configuraciones generales</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuración de imágenes del header -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white">
                            <i class="mdi mdi-image text-white mr-2"></i>
                            Configuración de Imágenes del Header
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Imagen Header Derecha -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-left-success h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="mdi mdi-image-area mr-2"></i>
                                            Imagen Header Derecha
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            <i class="mdi mdi-information mr-1"></i>
                                            Formatos permitidos: PNG, JPG | Tamaño recomendado: 200x80px
                                        </p>
										<!-- Botón para seleccionar la imagen -->
                                        <div class="upload-area border-dashed border-success rounded p-4 text-center mb-3">
                                            <div class="upload-icon mb-2">
                                                <i class="mdi mdi-cloud-upload text-success" style="font-size: 2rem;"></i>
                                            </div>
                                            <div class="upload-text">
                                                <p class="mb-2">Arrastra tu imagen aquí o</p>
                                                <label for="imagen_h_der" class="btn btn-outline-success btn-sm mb-0">
                                                    <i class="mdi mdi-folder-open mr-1"></i>Seleccionar archivo
                                                </label>
                                                <input type="file"
                                                       id="imagen_h_der"
                                                       name="imagen_h_der"
                                                       class="d-none"
                                                       accept="image/jpeg, image/png"
                                                       data-val="imagen_h_der">
                                            </div>
                                        </div>
										<!-- Previsualización de la imagen -->
                                        <div class="preview-area mb-3" id="preview_h_der" style="display: none;">
											<img id="img_preview_h_der" class="img-fluid rounded border" style="max-height: 100px;">
                                        </div>
										<!-- Botón para guardar la imagen -->
                                        <button type="button"
                                                class="btn btn-success w-100 imagen_header_der"
                                                data-name="imagen_h_der"
                                                id="h_der"
                                                disabled>
                                            <i class="mdi mdi-content-save mr-2"></i>Guardar Imagen Derecha
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen Header Izquierda -->
                            <div class="col-md-6 mb-4">
                                <div class="card border-left-info h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="mdi mdi-image-area mr-2"></i>
                                            Imagen Header Izquierda
                                        </h6>
                                        <p class="text-muted small mb-3">
                                            <i class="mdi mdi-information mr-1"></i>
                                            Formatos permitidos: PNG, JPG | Tamaño recomendado: 200x80px
                                        </p>
                                        
                                        <div class="upload-area border-dashed border-info rounded p-4 text-center mb-3">
                                            <div class="upload-icon mb-2">
                                                <i class="mdi mdi-cloud-upload text-info" style="font-size: 2rem;"></i>
                                            </div>
                                            <div class="upload-text">
                                                <p class="mb-2">Arrastra tu imagen aquí o</p>
                                                <label for="imagen_h_izq" class="btn btn-outline-info btn-sm mb-0">
                                                    <i class="mdi mdi-folder-open mr-1"></i>Seleccionar archivo
                                                </label>
                                                <input type="file" 
                                                       id="imagen_h_izq" 
                                                       name="imagen_h_izq" 
                                                       class="d-none" 
                                                       accept="image/jpeg, image/png" 
                                                       data-val="imagen_h_izq">
                                            </div>
                                        </div>
                                        
                                        <div class="preview-area mb-3" id="preview_h_izq" style="display: none;">
                                            <img id="img_preview_h_izq" class="img-fluid rounded border" style="max-height: 100px;">
                                        </div>
                                        
                                        <button type="button" 
                                                class="btn btn-info w-100 imagen_header_izq" 
                                                data-name="imagen_h_izq" 
                                                id="h_izq" 
                                                disabled>
                                            <i class="mdi mdi-content-save mr-2"></i>Guardar Imagen Izquierda
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="mdi mdi-lightbulb mr-2"></i>Recomendaciones
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Utiliza imágenes con fondo transparente (PNG) para mejor integración</li>
                                        <li>Mantén un tamaño consistente entre ambas imágenes</li>
                                        <li>Asegúrate de que las imágenes sean legibles en diferentes tamaños de pantalla</li>
                                        <li>El peso máximo recomendado por imagen es de 500KB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de navegación -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?php echo base_url('admin/operaciones'); ?>" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left mr-2"></i>Volver al Panel de Operaciones
                </a>
            </div>
        </div>
    </div>
</div>
</div>
<style>
	.border-dashed {
		border: 2px dashed !important;
	}

	.upload-area {
		transition: all 0.3s ease;
		cursor: pointer;
	}

	.upload-area:hover {
		background-color: #f8f9fa;
	}

	.upload-area.dragover {
		background-color: #e3f2fd;
		border-color: #2196f3 !important;
	}

	.border-left-success {
		border-left: 4px solid #28a745 !important;
	}

	.border-left-info {
		border-left: 4px solid #17a2b8 !important;
	}

	.preview-area img {
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
</style>
