import $ from "jquery";
// Importación de todos los archivos JS de una carpeta específica
const requireJS = require.context("./", false, /\.js$/);
requireJS.keys().forEach(requireJS);
