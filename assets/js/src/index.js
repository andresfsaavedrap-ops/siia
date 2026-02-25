// Importar todas las librerías como módulos
import $ from 'jquery';
import 'bootstrap';
import { Tempo } from '@formkit/tempo';
import 'datatables.net';

// Importar tus funciones personalizadas
import './functions/globals.js';
import './functions/main.js';
// ... otros imports

// Hacer jQuery disponible globalmente (para compatibilidad)
window.$ = window.jQuery = $;
