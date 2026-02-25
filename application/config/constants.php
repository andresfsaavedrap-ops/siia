<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');            // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/

defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0);                // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1);                    // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3);                  // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4);      // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5);    // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6);  // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7);          // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8);              // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9);            // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125);          // highest automatically-assigned error code
define('KEY_RDEL', 'd0a7e7997b6d5fcd55f4b5c32611b87c');              // Key AES For passwords d0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282
define('APP_URL_DATOS', 'datos.gov.co');                             // URL de datos abiertos
define('APP_DATOS_TOKEN', '34gNFwkJaEVjZQdRRrCPBHwGk');              // Token de la aplicación en datos abiertos
define('RECAPTCHA_KEY', '6LeTFnYnAAAAAIhB3zerDj5WTFRhG2XCILU6xIWL'); // Key recaptcha google
define('APP_DATOS_USER', 'uaeostics@gmail.com');                     // Usuario de la aplicación en datos abiertos
define('APP_DATOS_PASSWORD', 'Lr563serv*');                          // Contraseña de la aplicación en datos abiertos
define('EMAIl_PASSWORD', 'Acr3d1t4c10nes');
define('APP_DATOS_VIEWIUD', '2tsa-2de2');                                // https://www.datos.gov.co/resource/43dx-dcjb.json https://www.datos.gov.co/resource/9qtj-epz2.json
define('APP_NAME', 'Sistema Integrado de Información de Acreditación');  // Nombre del sistema
define('DIR', 'Carrera 10 No 15-22, Bogotá, D.C.');  // Dirección de la organización
define('PBX', '+(57) 601 327 52 52');  // Teléfono de la organización
define('CEL', '322 844 45 59');  // Teléfono de la organización
define('PAGINA_WEB', 'https://www.unidadsolidaria.gov.co/');             // Correo electrónico del SIIA para el contacto
define('CORREO_SIA', 'acreditaciones@unidadsolidaria.gov.co');           // Correo electrónico del SIIA para el contacto
define('CORREO_ATENCION', 'atencionalciudadano@unidadsolidaria.gov.co'); // Correo electrónico de ATENCIÓN AL CIUDADANO PRIORIDAD BAJA
define('CORREO_AREA', 'acreditaciones@unidadsolidaria.gov.co');          // Correo electrónico de COORDINADOR DE AREA PRIORIDAD ALTA
define('CORREO_DIRECTOR', 'acreditaciones@unidadsolidaria.gov.co');      // Correo electrónico de DIRECTOR NACIONAL PRIORIDAD MUY ALTA
define('SUPER_PS', 'Nm3BcJ7GJbUkIe0aLpd5');                              // PS de super // https://www.clavesegura.org/es/
define('PASSWORD_DB', '');
