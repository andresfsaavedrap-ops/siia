// Configuración global mejorada para DataTables con soporte para agrupación
window.DataTableConfig = {
    // Configuración base para todas las tablas
    getBaseConfig: function() {
        return {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "responsive": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                   '<"row"<"col-sm-12 col-md-12"B>>' +
                   '<"row"<"col-sm-12"tr>>' +
                   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
        };
    },
    // Configuración de botones de exportación
    getExportButtons: function(title, filename, columns) {
        return [
            {
                extend: 'collection',
                text: '<i class="mdi mdi-download mr-2"></i>Exportar',
                className: 'btn btn-primary btn-sm dropdown-toggle',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="mdi mdi-file-excel mr-2"></i>Excel',
                        className: 'btn btn-success btn-sm',
                        title: title + ' - ' + new Date().toLocaleDateString('es-ES'),
                        filename: filename + '_' + new Date().toISOString().slice(0,10),
                        exportOptions: {
                            columns: columns || ':visible',
                            modifier: {
                                page: 'all',
                                selected: false
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="mdi mdi-file-pdf mr-2"></i>PDF',
                        className: 'btn btn-danger btn-sm',
                        title: title,
                        filename: filename + '_' + new Date().toISOString().slice(0,10),
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: columns || ':visible',
                            modifier: {
                                page: 'all',
                                selected: false
                            }
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                            doc.styles.tableHeader.fontSize = 10;
                            doc.defaultStyle.fontSize = 8;
                            doc.content[0].text = title + ' - ' + new Date().toLocaleDateString('es-ES');
                            doc.content[0].alignment = 'center';
                            doc.content[0].fontSize = 16;
                            doc.content[0].margin = [0, 0, 0, 20];
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="mdi mdi-file-delimited mr-2"></i>CSV',
                        className: 'btn btn-info btn-sm',
                        filename: filename + '_' + new Date().toISOString().slice(0,10),
                        exportOptions: {
                            columns: columns || ':visible',
                            modifier: {
                                page: 'all',
                                selected: false
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="mdi mdi-printer mr-2"></i>Imprimir',
                        className: 'btn btn-secondary btn-sm',
                        title: title + ' - ' + new Date().toLocaleDateString('es-ES'),
                        exportOptions: {
                            columns: columns || ':visible',
                            modifier: {
                                page: 'all',
                                selected: false
                            }
                        }
                    }
                ]
            },
            {
                text: '<i class="mdi mdi-refresh mr-2"></i>Actualizar',
                className: 'btn btn-outline-primary btn-sm',
                action: function ( e, dt, node, config ) {
                    dt.ajax.reload();
                }
            }
        ];
    },
    // Configuración completa con botones de exportación
    getConfigWithExport: function(title, filename, columns) {
        var config = this.getBaseConfig();
        config.buttons = this.getExportButtons(title, filename, columns);
        return config;
    },
    // Nueva función: Configuración con agrupación por columna
    getConfigWithGrouping: function(title, filename, columns, groupColumn, exportColumns) {
        var config = this.getConfigWithExport(title, filename, exportColumns);
        // Configuración específica para agrupación
        config.order = [[ groupColumn, 'asc' ]];
        config.columnDefs = [
            { "visible": false, "targets": groupColumn }
        ];
        config.drawCallback = function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
						// Icono de tabla de grupo
                        '<tr class="group"><td colspan="' + columns + '"><i class="mdi mdi-domain mr-2"></i><strong>' + group + '</strong></td></tr>'
                    );
                    last = group;
                }
            } );
        };
        return config;
    },
    // Función para inicializar tabla con agrupación
    initGroupedTable: function(tableId, title, filename, totalColumns, groupColumn, exportColumns) {
        var config = this.getConfigWithGrouping(title, filename, totalColumns, groupColumn, exportColumns);
        var table = $(tableId).DataTable(config);
        // Evento para colapsar/expandir grupos
        $(tableId + ' tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
                table.order( [ groupColumn, 'desc' ] ).draw();
            }
            else {
                table.order( [ groupColumn, 'asc' ] ).draw();
            }
        });
        return table;
    },
    // Función para inicializar tabla simple
    initSimpleTable: function(tableId, title, filename, columns) {
        var config = this.getConfigWithExport(title, filename, columns);
        // habilitar selección si el plugin está disponible
        config.select = config.select || { style: 'multi', blurable: true };
        var table = $(tableId).DataTable(config);
        // Al hacer clic fuera del contenedor, deseleccionar filas
        $(document).on('click', function(e){
            if (!$(e.target).closest(tableId).length) {
                try {
                    if (table.select && table.rows({ selected: true }).deselect) {
                        table.rows({ selected: true }).deselect();
                    } else {
                        $(tableId + ' tbody tr.selected').removeClass('selected');
                    }
                } catch(err) {}
            }
        });
        return table;
    }
};
var __stripHtml = function(d){return typeof d === 'string' ? d.replace(/<[^>]*>/g,'').trim() : d;};
$.fn.dataTable.ext.type.detect.unshift(function (d) {
    d = __stripHtml(d);
    if (!d || typeof d !== 'string') return null;
    var m = d.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    return m ? 'date-eu' : null;
});
$.fn.dataTable.ext.type.order['date-eu-pre'] = function (d) {
    d = __stripHtml(d);
    var m = d && typeof d === 'string' ? d.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/) : null;
    if (!m) return 0;
    return new Date(parseInt(m[3],10), parseInt(m[2],10)-1, parseInt(m[1],10)).getTime();
};
// Cargar estilos CSS automáticamente
if (!document.getElementById('datatable-styles-link')) {
    var link = document.createElement('link');
    link.id = 'datatable-styles-link';
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = '/siia/assets/css/datatable-styles.css';
    document.head.appendChild(link);
}
// Configuración para ajuste automático de columnas
const autoWidthConfig = {
    autoWidth: true,
    responsive: true,
    scrollX: false, // Desactivar scroll horizontal forzado
    columnDefs: [
        {
            targets: '_all',
            className: 'text-wrap', // Permitir wrap del texto en celdas
        }
    ],
    initComplete: function() {
        // Ajustar columnas después de la inicialización
        this.api().columns.adjust();
        // Solo activar scroll si realmente es necesario
        var table = this.api().table();
        var container = $(table.container());
        var tableWidth = $(table.table().node()).outerWidth();
        var containerWidth = container.parent().width();
        if (tableWidth > containerWidth) {
            container.find('.table-responsive').addClass('force-scroll');
        }
    }
};
// Aplicar a todas las tablas
$('.dataTable').DataTable(autoWidthConfig);

// Configuración específica para filtros de organizaciones acreditadas
window.DataTableConfig.acreditadasFilters = {
    // Función para filtrar por estado de acreditación
    filterByStatus: function(tableId, status) {
        var table = $(tableId).DataTable();
        
        // Limpiar filtros anteriores de la columna de estado
        table.column(6).search('').draw();
        
        if (status === 'todas') {
            // Mostrar todas las filas
            table.search('').draw();
        } else {
            // Usar búsqueda personalizada para filtrar por atributo data-estado
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.nTable.id !== tableId.replace('#', '')) {
                        return true;
                    }
                    
                    var row = table.row(dataIndex).node();
                    var estadoBadge = $(row).find('[data-estado]');
                    
                    if (estadoBadge.length > 0) {
                        var estadoData = estadoBadge.attr('data-estado');
                        return estadoData === status;
                    }
                    
                    return false;
                }
            );
            table.draw();
            // Limpiar el filtro personalizado después de usarlo
            $.fn.dataTable.ext.search.pop();
        }
    },

    // Función para filtrar por modalidad
    filterByModality: function(tableId, modality) {
        var table = $(tableId).DataTable();
        
        if (modality === '') {
            // Limpiar filtro de modalidad
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function(fn) {
                return fn.name !== 'modalityFilter';
            });
        } else {
            // Agregar filtro de modalidad
            var modalityFilter = function(settings, data, dataIndex) {
                if (settings.nTable.id !== tableId.replace('#', '')) {
                    return true;
                }
                
                var row = table.row(dataIndex).node();
                var modalidadBadge = $(row).find('[data-modalidad]');
                
                if (modalidadBadge.length > 0) {
                    var modalidadData = modalidadBadge.attr('data-modalidad');
                    return modalidadData === modality;
                }
                
                return false;
            };
            modalityFilter.name = 'modalityFilter';
            
            // Remover filtro anterior si existe
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function(fn) {
                return fn.name !== 'modalityFilter';
            });
            
            $.fn.dataTable.ext.search.push(modalityFilter);
        }
        
        table.draw();
    },
    
    // Función para limpiar todos los filtros personalizados
    clearAllFilters: function(tableId) {
        var table = $(tableId).DataTable();
        
        // Limpiar filtros de búsqueda global y por columna
        table.search('').columns().search('').draw();
        
        // Limpiar filtros personalizados
        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function(fn) {
            return fn.name !== 'modalityFilter';
        });
        
        table.draw();
    }
};
