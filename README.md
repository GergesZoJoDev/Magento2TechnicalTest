
# Magento 2 Technical Test

El presente proyecto es el resultado de una prueba técnica solicitada en Magento 2(v2.4.6) utilizando Composer, Docker, OpenSearch y MariaDB.

## Prerequisites

El presente setup asume que Docker ya se encuentra corriendo sobre tu computadora. [Descarga e instala Docker Desktop](https://www.docker.com/products/docker-desktop).

Esta configuración ha sido probada sobre MacOS.

## Instalación del proyecto

Una vez realizada la clonación del presente proyecto se recomienda realizar los siguientes pasos:

- Obtener las llaves de acceso publica y privada del sitio: ``` https://commercemarketplace.adobe.com/ ```
- Seleccionar un nombre de dominio desde el cual te gustaría acceder al sitio y agregalo a tu archivo host mediante el comando: ``` sudo -- sh -c "echo '127.0.0.1 local.domain.com' >> /etc/hosts" ```
- Ejecutar el comando siguiente ``` docker-compose up -d --build ``` con el cual Docker realizará la descarga y ejecución de las imagenes necesarias para visualizar el proyecto en el navegador.
- Asegurese de que todas las imagenes se encuentran en ejecución. Para validar hasta este momento visite en su navegador la siguiente URL ``` http://127.0.0.1:8080 ``` o ``` http://localhost:8080 ``` si visualiza ```phpMyAdmin```, felicitaciones la instalación al momento es favorable.
- Accesa a la linea de comandos de su contenedor Docker llamado web, mediante el comando siguiente: ```docker exec -it web bash````
- Debe ir al directorio raíz del proyecto dentro de su contenedor mediante el comando: ```cd /app```
- Aunque este paso es opcional, se recomienda realizar la implementación de datos de prueba mediante el comando: ```php bin/magento sampledata:deploy```
- Al termino de la implementación de datos de prueba, ejecute el siguiente comando encargado de instalar Magento 2
```bash
php bin/magento setup:install \
--admin-firstname=Gerges \
--admin-lastname=Zamudio \
--admin-email=gergeszojodeve@gmail.com \
--admin-user=admin \
--admin-password='Password123' \
--base-url=https://local.domain.com \
--base-url-secure=https://local.domain.com \
--backend-frontname=admin \
--db-host=mysql \
--db-name=magento \
--db-user=root \
--db-password=root \
--use-rewrites=1 \
--language=en_US \
--currency=USD \
--timezone=America/Mexico_City \
--use-secure-admin=1 \
--admin-use-security-key=1 \
--session-save=files \
--use-sample-data \
--search-engine=opensearch \
--opensearch-host=opensearch \
--opensearch-port=9200 \
--opensearch-index-prefix=magento2 \
--opensearch-timeout=15
```
- Abra en su navegador la URL https://local.domain.com o el dominio que hayas elegido agregar al archivo host anteriormente. Al visitar el sitio por primera vez va a tomar algunos minutos en cargar. Esto se debe a que no existe nada cacheado y el sistema de Magento creará automáticamente archivos cuando cargue las paginas. La carga posterior será más rápida.

  Adicionalmente, debido a que el contenedor aplica un certificado SSL autogenerado, podrías recibir una alerta de seguridad desde el navegador cuando visites la URL por primera vez.
- Felicitaciones! Ha configurado satisfactoriamente Magento 2 en Docker.

Nota: El proyecto no se encuentra configurado para envío de correos, debido a eso es recomendable desactivar la autenticación de dos pasos, mediante el comando siguiente ``` php bin/magento module:disable Magento_TwoFactorAuth ``` o abra el archivo ``` app/etc/config.php ``` y cambie el valor de ``` Magento_TwoFactorAuth ``` y ``` Magento_AdminAdobeImsTwoFactorAuth ``` a ``` 0 ```. Posteriormente ejecute el comando : ``` php bin/magento setup:di:compile ``` para compilar tu proyecto.
