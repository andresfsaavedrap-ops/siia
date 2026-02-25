// Importaciones necesarias
import { toastSimple, mostrarAlerta, procesando, errorControlador, confirmarAccion, errorValidacionFormulario } from '../../partials/alerts-config.js';
import { redirect, reload } from '../../partials/other-funtions-init.js';
import { getBaseURL } from '../../config.js';
// Configurar baseURL
const baseURL = getBaseURL();
// Inicializar validación del formulario cuando el DOM esté listo
$(document).ready(function() {
	// Función para manejar la previsualización de imágenes
    function handleImagePreview(input, previewId, buttonId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        const button = document.getElementById(buttonId);
        if (file) {
            // Validar tipo de archivo
            if (!file.type.match('image.*')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo no válido',
                    text: 'Por favor selecciona una imagen válida (PNG o JPG)'
                });
                input.value = '';
                return;
            }
            // Validar tamaño (500KB máximo)
            if (file.size > 500000) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo muy grande',
                    text: 'El archivo debe ser menor a 500KB'
                });
                input.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = preview.querySelector('img');
                imgElement.src = e.target.result;
                preview.style.display = 'block';
                button.disabled = false;
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            button.disabled = true;
        }
    }
    // Event listeners para los inputs de archivo
    $('#imagen_h_der').change(function() {
        handleImagePreview(this, 'preview_h_der', 'h_der');
    });
    $('#imagen_h_izq').change(function() {
        handleImagePreview(this, 'preview_h_izq', 'h_izq');
    });
    // Drag and drop functionality
    $('.upload-area').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    $('.upload-area').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    $('.upload-area').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            const input = $(this).find('input[type="file"]')[0];
            input.files = files;
            $(input).trigger('change');
        }
    });
    // Click en el área de upload
    $('.upload-area').click(function() {
        $(this).find('input[type="file"]').click();
    });
    // Función consolidada para cargar imágenes del sistema
    function uploadSystemImage(logoType, fileInputId, buttonElement) {
        const fileInput = document.getElementById(fileInputId);
        const file = fileInput.files[0];
        
        if (!file) {
            mostrarAlerta('error', 'Error', 'Por favor selecciona una imagen');
            return;
        }
        
        // Validaciones del archivo
        if (!file.type.match('image.*')) {
            mostrarAlerta('error', 'Archivo no válido', 'Por favor selecciona una imagen válida (PNG, JPG o JPEG)');
            return;
        }
        
        if (file.size > 10485760) { // 10MB
            mostrarAlerta('warning', 'Archivo muy grande', 'El archivo debe ser menor a 10MB');
            return;
        }
        
        const formData = new FormData();
        formData.append('file', file);
        formData.append('logo_type', logoType);
        
        const originalText = $(buttonElement).html();
        
        $.ajax({
            url: baseURL + "Operaciones/uploadSystemLogo",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            beforeSend: function() {
                $(buttonElement).html('<i class="mdi mdi-loading mdi-spin mr-2"></i>Guardando...');
                $(buttonElement).prop('disabled', true);
                procesando('Subiendo imagen...');
            },
            success: function(response) {
                if (response.success) {
                    toastSimple('success', response.msg);
                    // Actualizar la imagen en la interfaz si existe preview
                    const previewImg = $(buttonElement).closest('.upload-section').find('img');
                    if (previewImg.length && response.image_url) {
                        previewImg.attr('src', baseURL + response.image_url + '?t=' + new Date().getTime());
                    }
                } else {
                    mostrarAlerta('error', 'Error', response.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error uploading image:', error);
                errorControlador('Error al subir la imagen. Intente nuevamente.');
            },
            complete: function() {
                $(buttonElement).html(originalText);
                $(buttonElement).prop('disabled', false);
                Swal.close();
            }
        });
    }
    
    // Event listeners consolidados para los botones de carga
    $(document).on('click', '.upload-logo-btn', function(e) {
        e.preventDefault();
        const logoType = $(this).data('logo-type');
        const fileInputId = $(this).data('file-input');
        
        if (!logoType || !fileInputId) {
            mostrarAlerta('error', 'Error', 'Configuración de botón incorrecta');
            return;
        }
        
        uploadSystemImage(logoType, fileInputId, this);
    });
    
    // Mantener compatibilidad con botones existentes
    $(".imagen_header_der").on("click", function(e) {
        e.preventDefault();
        uploadSystemImage('logo_app', 'imagen_h_der', this);
    });
    
    $(".imagen_header_izq").on("click", function(e) {
        e.preventDefault();
        uploadSystemImage('logo', 'imagen_h_izq', this);
    });
});
