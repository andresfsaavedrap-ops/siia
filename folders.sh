#sudo java -jar /home/loto/schemaspy-6.0.0.jar -t mysql -db siia -host localhost -u loto -p root -o /var/www/html/schema -dp /home/loto/mysql-connector-java-5.1.30.jar -s siia
#!/bin/bash
##For cronjob in prod/dev = 30 2 * * * php -q /var/www/html/siia/index.php Recordar calculo_tiempo &> /var/www/html/siia/application/logs/enviomailtiempo.txt
##For cronjob in prod/dev = 30 23 * * * php -q /var/www/html/siia/index.php Recordar recordarToAdmin &> /var/www/html/siia/application/logs/enviomailtiempo.txt
##For cronjob in prod/dev = 30 22 * * * php -q /var/www/html/siia/index.php Recordar recordarToUser &> /var/www/html/siia/application/logs/enviomailtiempo.txt
##For cronjob in prod/dev = 30 21 * * * php -q /var/www/html/siia/index.php Recordar recordarToUserActivation &> /var/www/html/siia/application/logs/enviomailtiempo.txt
##For cronjob in prod/dev = 0 8 */5 * * php -q /var/www/html/siia/index.php Recordar recordarToCamaraMail &> /var/www/html/siia/application/logs/enviomailcamaras.txt
##For cronjob in prod/dev = 0 8 */5 * * php -q /var/www/html/siia/index.php Recordar recordarToAsignarMail &> /var/www/html/siia/application/logs/enviomailasginar.txt

##service cron start
## ALTER TABLE administradores AUTO_INCREMENT = 99999999;
## SET GLOBAL FOREIGN_KEY_CHECKS=0;
mkdir -p uploads
cd uploads
mkdir asistentes camaraComercio observacionesPlataforma resoluciones docentes jornadas materialDidacticoProgBasicos materialDidacticoAvalEconomia materialDidacticoProgAvalar formatosEvalProgAvalar registrosEducativos instructivosPlataforma lugarAtencion cartaRep certificaciones logosOrganizaciones certifcadoExistencia instructivoEnLinea autoevaluaciones
cd logosOrganizaciones
mkdir firma
mkdir firmaCert
cp -R ../../assets/img/default.png firma
cp -R ../../assets/img/default.png firmaCert
cp -R ../../assets/img/default.png .
chmod -R 777 *
cd ../
## Esto es para la carpeta docentes
cd docentes
mkdir hojasVida titulos certificados certificadosEconomia
chmod -R 777 *
cd ..
chmod -R 777 *
exit
