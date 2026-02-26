<?php
/**
 * Router para servidor PHP integrado
 * Simula el comportamiento de mod_rewrite de Apache
 */

// Obtener la URI solicitada
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Si es un archivo real (CSS, JS, imágenes, etc.), servirlo directamente
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Redirigir todo al index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
