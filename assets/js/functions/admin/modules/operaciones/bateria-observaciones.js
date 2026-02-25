import { getBaseURL } from "../../../config.js";
import {
    alertaGuardado,
    mostrarAlerta,
    toastSimple,
    errorControlador,
    confirmarAccion
} from "../../../partials/alerts-config.js";

const baseURL = getBaseURL();

// Configuración única para evitar duplicar handlers
// Inicialización única para evitar duplicar handlers y conflictos
if (!window.__bateriaObservacionesInitialized) {
    window.__bateriaObservacionesInitialized = true;

    // Neutralizar posibles handlers antiguos del toggle personalizado
    $(document).off("click", "#floatingObservacionesToggle");

    // Si el contenedor no está directamente bajo <body>, muévelo para evitar clipping
    const $menu = $("#floatingObservacionesContainer");
    if ($menu.length && !$menu.parent().is("body")) {
        $("body").append($menu.detach());
    }

    // Inicializar el dropdown de Bootstrap si está disponible
    try { $("#floatingObservacionesToggle").dropdown(); } catch (e) { /* noop */ }

    // Actualizar flecha según estado del dropdown (solo una flecha: #floatingObservacionesChevron)
    $("#floatingObservacionesContainer").on("show.bs.dropdown", function () {
        $("#floatingObservacionesChevron").removeClass("fa-chevron-up").addClass("fa-chevron-down");
    });
    $("#floatingObservacionesContainer").on("hide.bs.dropdown", function () {
        $("#floatingObservacionesChevron").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    });

    // Cerrar el dropdown al elegir un item
    $(document).on("click", "#floatingObservacionesPanel .dropdown-item", function () {
        try { $("#floatingObservacionesToggle").dropdown("hide"); } catch (e) {}
    });
    // Event handlers para las opciones del menú
    $(document).on("click", "#verObservacionesGenerales", function() {
		mostrarSeccionObservaciones('generales');
    });

    $(document).on("click", "#verObservacionesInformacion", function() {
        mostrarSeccionObservaciones('informacion');
    });

    $(document).on("click", "#verObservacionesDocumentacion", function() {
        mostrarSeccionObservaciones('documentacion');
    });

    $(document).on("click", "#verObservacionesJornadas", function() {
        mostrarSeccionObservaciones('jornadas');
    });

    $(document).on("click", "#verObservacionesProgramas", function() {
        mostrarSeccionObservaciones('programas');
    });

    $(document).on("click", "#verObservacionesFacilitadores", function() {
        mostrarSeccionObservaciones('facilitadores');
    });

    $(document).on("click", "#verObservacionesModalidades", function() {
        mostrarSeccionObservaciones('modalidades');
    });

    $(document).on("click", "#crearNuevaObservacion", function() {
        console.log('Crear nueva observación clickeado');
        // Buscar modal existente o crear uno simple
        if ($('#modalBateriaObservaciones').length) {
            $('#modalBateriaObservaciones').modal('show');
        } else {
            // Crear un modal simple si no existe
            toastSimple('info', 'Función de crear observación - En desarrollo');
            console.log('Modal de observaciones no encontrado, mostrando mensaje temporal');
        }
    });

    $(document).on("click", "#exportarObservaciones", function() {
        console.log('Exportar observaciones clickeado');
        exportarObservaciones();
    });
}

/**
 * Mostrar sección específica de observaciones
 */
function mostrarSeccionObservaciones(tipo) {
    console.log(`Mostrando sección de observaciones: ${tipo}`);
    // Verificar si estamos en la vista correcta
    if (!$('#admin_panel_ver_finalizada').length) {
        console.log('No se encontró el panel principal, intentando mostrar secciones existentes');
        // Buscar secciones existentes en la página
        const secciones = {
            'generales': '#admin_ver_finalizadas, .container',
            'informacion': '#verInfGenMenuAdmin, #admin_panel_ver_finalizada',
            'documentacion': '#verDocLegalMenuAdmin',
            'jornadas': '#verJorActMenuAdmin',
            'programas': '#verProgBasMenuAdmin',
            'facilitadores': '#verFaciliMenuAdmin',
            'modalidades': '#verDatModalidades'
        };
        // Si hay elementos relacionados, hacer clic en ellos
        if (secciones[tipo]) {
            const elemento = $(secciones[tipo]).first();
            if (elemento.length) {
                elemento.trigger('click');
                toastSimple('info', `Navegando a: ${tipo}`);
                return;
            }
        }
    }
    // Lógica original para cuando existen las secciones específicas
    $('.seccion-observaciones').hide();
    $(`#seccion-${tipo}`).show();
    const titulos = {
        'generales': 'Observaciones Generales',
        'informacion': 'Observaciones - Información General',
        'documentacion': 'Observaciones - Documentación Legal',
        'jornadas': 'Observaciones - Jornadas de Actualización',
        'programas': 'Observaciones - Programas Básicos',
        'facilitadores': 'Observaciones - Facilitadores',
        'modalidades': 'Observaciones - Modalidades'
    };
    
    $('.titulo-seccion-observaciones').text(titulos[tipo] || 'Observaciones');
    cargarObservacionesPorTipo(tipo);
    toastSimple('info', `Mostrando: ${titulos[tipo]}`);
}

/**
 * Cargar observaciones por tipo
 */
function cargarObservacionesPorTipo(tipo) {
    // Aquí puedes implementar la lógica para cargar observaciones específicas
    console.log(`Cargando observaciones de tipo: ${tipo}`);
    // Ejemplo de implementación:
    /*
    $.ajax({
        url: baseURL + "Operaciones/getObservacionesPorTipo",
        type: "POST",
        data: { tipo: tipo },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                actualizarTablaObservaciones(response.data, tipo);
            } else {
                toastSimple('error', response.message || 'Error al cargar observaciones');
            }
        },
        error: function() {
            toastSimple('error', 'Error de conexión al cargar observaciones');
        }
    });
    */
}

/**
 * Exportar observaciones
 */
function exportarObservaciones() {
    console.log('Iniciando exportación de observaciones');
    
    confirmarAccion(
        '¿Exportar observaciones?',
        'Se generará un archivo con todas las observaciones del sistema',
        function() {
            // Implementar lógica de exportación
            window.open(baseURL + "Operaciones/exportarObservaciones", '_blank');
            toastSimple('success', 'Iniciando exportación de observaciones');
            console.log('Exportación confirmada por el usuario');
        }
    );
}

/**
 * Actualizar tabla de observaciones
 */
function actualizarTablaObservaciones(data, tipo) {
    const tabla = $(`#tabla-observaciones-${tipo}`);
    if (tabla.length) {
        // Limpiar tabla
        tabla.find('tbody').empty();
        // Agregar nuevos datos
        data.forEach(observacion => {
            const fila = `
                <tr>
                    <td>${observacion.id}</td>
                    <td>${observacion.titulo}</td>
                    <td>${observacion.descripcion}</td>
                    <td>${observacion.fecha}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="editarObservacion(${observacion.id})">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarObservacion(${observacion.id})">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            `;
            tabla.find('tbody').append(fila);
        });
    }
}
// Funciones globales para compatibilidad
window.mostrarSeccionObservaciones = mostrarSeccionObservaciones;
window.cargarObservacionesPorTipo = cargarObservacionesPorTipo;
window.exportarObservaciones = exportarObservaciones;
