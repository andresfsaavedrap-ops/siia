# SIIA (Sistema Integrado de Información de Acreditación) - Unidad Solidaria

El SIIA es el sistema de acreditación de Organizaciones Solidarias para que entidades/organizaciones como cooperativas en el "tramite" de solicitud de la Acreditación, la aplicación SIIA se creó desde cero para no solamente dar la parte del trámite sino poder obtener más información, como la de las organizaciones históricas, el informe de actividades, el módulo de docentes, reportes entre otros.

## Estado del diseño y arquitectura (Actualizado)

- Backend: CodeIgniter (PHP) con MVC, controladores en application/controllers, modelos en application/models y vistas en application/views.
- Base de datos: MySQL; el esquema inicial está en application/database/squema.sql (ver sección de instalación).
- Frontend: Gestión de assets con Webpack 5. El punto de entrada está en assets/js/src/index.js y el bundle se genera en assets/dist/bundle.js.
- UI/Recursos: assets/css, assets/js, assets/img contienen estilos, scripts y recursos; se emplea jQuery y DataTables.
- Módulos principales: gestión de organizaciones, acreditaciones, docentes, informes de actividades, seguimiento, resoluciones y paneles separados para admin/super/usuario.
- Seguridad: uso de .htaccess para rewrites, configuración de base_url y cookie_domain en application/config/config.php, y constantes sensibles en application/config/constants.php.

## Empezando

Estas instrucciones le permitirán obtener una copia del proyecto en funcionamiento en su máquina local para fines de desarrollo y prueba. Consulte la implementación para obtener notas sobre cómo implementar el proyecto en un sistema en vivo.

### Requisitos rápidos por sistema (nuevo)

- Común:
  - PHP 7.4+ (recomendado)
  - MySQL 5.7 o 8.0
  - Apache 2.4 con mod_rewrite y mod_headers
  - Node.js 18+ y npm (para compilar assets)
  - Git (opcional)

- Windows (Dev):
  - XAMPP/WAMP o Apache+PHP+MySQL configurados manualmente
  - Usar http://localhost/siia como base_url para desarrollo

- Linux (Prod/Dev):
  - Ubuntu 16.04+ (o superior), Apache2, PHP7.4+, MySQL, Git

### Prerequisitos

Qué cosas necesitas para instalar el software y cómo instalarlas:

Actulizar Sistema Operativo

```
# apt-get update
# apt-get dist-upgrade ó upgrade
```

Apache - Ubuntu >= 16.04 LTS

```
# apt-get install apache2
```

MySQL

```
# apt-get install mysql-server
```

PHP >= 7.0 - Ubuntu >= 16.04 LTS

```
Ejemplo versiones = php7.x-dev

# apt-get install php7.0
# apt-get install php7.4-mysql php-curl php7.4-gd php7.4-imagick php7.4-imap php7.4-mcrypt php7.4-memcache php7.4-pspell php7.4-snmp php7.4-tidy php7.4-xmlrpc php7.4-xsl php7.4-dev -y
# apt-get install php libapache2-mod-php
# php --version
```

Activar modulos - Ubuntu >= 16.04 LTS

```
# a2enmod headers
# a2enmod expires
# a2enmod rewrite
# a2enmod ssl > Si es necesario para dominios con SSL.
```

Si es necesario instalar Git

```
# apt-get install git
```

### Instalando

Una serie de ejemplos paso a paso que indican que debe ejecutar un entorno de desarrollo - Ubuntu >= 16.04 LTS

Activar MultiViews en Apache

```
# nano /etc/apache2/sites-available/000-default.conf

<Directory /var/www/html/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
</Directory>

Guardar y salir.

# service apache2 restart
```

Cambiando el nombre del directorio a SIIA

```
# cd /var/www/html/
# mv sia_org_solidarias siia
```

Cambiando de branch en git para pruebas

```
# cd /var/www/html/siia
# git branch dev
```

## Corriendo el proyecto - Dev

CodeIgniter requiere hacer (si existe omitir el paso)

```
# cd /var/www/html/siia/
# nano index.php
	Editar la linea 56.
		define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');
	a
		define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'testing');

	Guardar y salir.
```

Ejecutar bash para los folder de uploads

```
# cd /var/www/html/siia/
# sh FOLDERS_SIIA.sh
```

Crear base de datos limpia en MySQL

```
# mysql -u root -p
> create database siia;
> exit;
# mysql siia < /var/www/html/siia/siiaRecursos/siia_clean.sql
# mysql -u root -p
> use siia;
> ALTER TABLE administradores AUTO_INCREMENT = 99999999;
> exit;
```

Cambiar el archivo de configuracion de CodeIgniter

```
# cd /var/www/html/siia/application/config
# nano config.php

	$config['base_url'] = 'http://10.5.5.5/siia/';

	$config['cookie_domain'] = '10.5.5.5';

	Guardar y salir.
```

Abrimos el explorador y entramos a la ip del servidor al proyecto por ejemplo: http://10.5.5.5/siia/home

### Analice las pruebas de extremo a extremo

Agregar administradores

```
http://10.5.5.5/siia/super/?
```

Verificar el ingreso de administradores

```
http://10.5.5.5/siia/admin
```

### Pruebas de estilo de codificación

Archivo database.php para verificar el usuario y contraseña en MySQL

```
# cd /var/www/html/siia/application/config
# nano database.php
```

Archivo constants.php para verificar contraseña super administrador "SUPER_PS"
Para verificar correos electronicos de contacto "CORREO_SIA" "CORREO_ATENCION"

```
# cd /var/www/html/siia/application/config
# nano constants.php
```

## Producción

Agregar los CronJobs

```
30 2 * * * php -q /var/www/html/sia/index.php Recordar calculo_tiempo &> /var/www/html/sia/application/logs/enviomailtiempo.txt
30 23 * * * php -q /var/www/html/sia/index.php Recordar recordarToAdmin &> /var/www/html/sia/application/logs/enviomailtiempo.txt
```

CodeIgniter requiere hacer

```
# cd /var/www/html/siia/
# nano index.php
	Editar la linea 56.
		define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'testing');
	a
		define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'production');

	Guardar y salir.
```

Cambiar la carpeta root de apache a siia

```
# nano /etc/apache2/sites-available/000-default.conf

DocumentRoot /var/www/html/siia

Guardar y salir.

# service apache2 restart
```

Cambiar el .htaccess comentando la RewriteBase /siia/

```
# cd /var/www/html/siia
# nano .htaccess

	RewriteBase /
	#RewriteBase /siia/

	Guardar y salir.
```

Cambiar el archivo de configuracion de CodeIgniter

```
# cd /var/www/html/siia/application/config
# nano config.php

	$config['base_url'] = 'http://10.5.5.5';

	$config['cookie_domain'] = '10.5.5.5';

	Guardar y salir.
```

Abrimos el explorador y entramos a la ip del servidor al proyecto por ejemplo: http://10.5.5.5/home

## Creado con

- [CodeIgniter](https://codeigniter.com/) - Framework
- [Apache](https://httpd.apache.org/) - Dependencia
- [PHP](http://php.net/) - Dependencia

## Versiones

Se usa [SemVer](http://semver.org/) para versiones.

## Autores

- **Sergio Daniel Martínez Porras** - _Trabajo Inicial_ - [M4RS](https://bitbucket.org/M4RS/)
- **Camilo Ríos Hernandez** - _Desarrollo de modulos nuevos y ajustes en el codigo anterior_

## Licencia

Este proyecto está bajo los derechos de autor del desarrollador y de la Unidad Solidaria
