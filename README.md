
# Magento 2 Technical Test

El presente proyecto es el resultado de una prueba técnica solicitada en Magento 2(v2.4.6) utilizando Composer, Docker, OpenSearch y MariaDB.

## Prerequisitos

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
```
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

## Crear un Módulo

- Solicitud:

  Desarrolla un módulo que redirija a una página específica y muestre un mensaje, manteniendo el diseño del sitio (cabecera, footer y layout completo).

- Solución: 
  
  Se creó el modulo ``` CustomVendor_CustomModule ``` y dentro de este un directorio/carpeta de controlador llamado ``` Index ``` el cual contiene dos clases de controlador/acción llamadas ``` Index ``` y ``` Other ```; el primero( ``` Index ``` ) representa el directorio raíz del modulo al cual se accede mediante la URL ``` \custommodule ``` o ``` \custommodule\index\index ```. La funcionalidad aplicada para la URL mencionada es redireccionar a una nueva URL que apunta a la clase de controlador/acción llamada ``` Other ```, dicha clase mediante su ruta es llamada a un layout el cual muestra el contenido del template ``` welcome.phtml ``` que contiene el mensaje ``` Texto Prueba ```. 

## Configuración de la Tienda

- Solicitud:

  Agrega campos "sobreprecio" y "costo de envío" en Store
  -> Configuration -> “Mi Configuración”, que sean editables por el administrador.

- Solución: 

  Se creó el archivo ``` system.xml ``` en del directorio ``` \etc\adminhtml ``` y dentro de dicho archivo se estableció un nuevo tab con etiqueta "Mi Configuración" la cual, contendrá una sección con etiqueta "Sobreprecio y costo de envío" encargado de mostrar los campos "sobreprecio" y "costo de envío".

  De igual manera se creó el archivo  ``` config.xml ``` dentro del directorio ``` \etc ``` el cual contiene la configuración default para los nuevos campos generados.

## Extensión de Módulo del Core

- Solicitud:

  Modifica la funcionalidad de búsqueda para cambiar el precio de los productos sumando el "sobreprecio"

- Solución: 
  
  Se creó el archivo ``` di.xml ``` en el directorio ``` \etc ``` y dentro de dicho archivo se estableció un plugin que apunta al archivo ``` FinalPricePlugin.php ``` que se encuentra en el directorio ``` \Plugin ``` el cual se encarga de obtener el precio del producto y sumar el campo "sobreprecio" para posteriormente ser retornado y mostrado en frontend. 

## Nuevo Método de Envío

- Solicitud:

  Implementa un método de envío con un costo basado en el campo "costo de envío" y que esté disponible en el checkout.

- Solución: 
  
  Se agregó dentro del archivo ``` config.xml ``` ubicado en el directorio ``` \etc ``` el siguiente contenido con la finalidad de establecer valores default para el nuevo método de envío personalizado:
  
```
  <carriers>
    <customshipping>
        <active>1</active>
        <sallowspecific>0</sallowspecific>
        <model>CustomVendor\CustomModule\Model\Carrier</model>
        <name>Custom Shipping</name>
        <price>10.0</price>
        <title>Custom Shipping</title>
        <specificerrmsg>Este método de envío no está habilitado. Para usar este método de envío por favor contactanos.</specificerrmsg>
        <handling_type>F</handling_type>
    </customshipping>
  </carriers>
```
Se creó el archivo ``` Carrier.php ``` en el directorio ``` \Model ``` dentro del cual en la función ``` getShippingPrice() ``` se realiza la sumatoria del precio default(``` $this->getConfigData('price') ```) del método de envío personalizado y el campo personalizado "costo de envío"(``` $this->scopeConfig->getValue('custommodule/general/display_text_2', ScopeInterface::SCOPE_STORE) ```).

Se agregó dentro del archivo ``` system.xml ``` ubicado en el directorio ``` \etc\adminhtml ``` el siguiente contenido para mostrar la información default del método de envío personalizado:
  
  Nota: Para visualizar el formulario default dentro del admin debe dirigirse a ``` Stores\Configuration\Sales\Delivery Methods ``` y el formulario del método de envío personalizado será mostrado como la segunda opción de métodos de envíos. 
```
    <section id="carriers" translate="label" type="text" sortOrder="320" showInDefault="1" showInWebsite="1" showInStore="1">
        <group id="simpleshipping" translate="label" type="text" sortOrder="0" showInDefault="1" showInWebsite="1" showInStore="1">
            <label>Mageplaza Simple Shipping Method</label>
            <field id="active" translate="label" type="select" sortOrder="1" showInDefault="1" showInWebsite="1" showInStore="0" canRestore="1">
                <label>Enabled</label>
                <source_model>Magento\Config\Model\Config\Source\Yesno</source_model>
            </field>
            <field id="name" translate="label" type="text" sortOrder="3" showInDefault="1" showInWebsite="1" showInStore="1" canRestore="1">
                <label>Method Name</label>
            </field>
            <field id="price" translate="label" type="text" sortOrder="5" showInDefault="1" showInWebsite="1" showInStore="0" canRestore="1">
                <label>Price</label>
                <validate>validate-number validate-zero-or-greater</validate>
            </field>
            <field id="handling_type" translate="label" type="select" sortOrder="7" showInDefault="1" showInWebsite="1" showInStore="0" canRestore="1">
                <label>Calculate Handling Fee</label>
                <source_model>Magento\Shipping\Model\Source\HandlingType</source_model>
            </field>
            <field id="handling_fee" translate="label" type="text" sortOrder="8" showInDefault="1" showInWebsite="1" showInStore="0">
                <label>Handling Fee</label>
                <validate>validate-number validate-zero-or-greater</validate>
            </field>
            <field id="sort_order" translate="label" type="text" sortOrder="100" showInDefault="1" showInWebsite="1" showInStore="0">
                <label>Sort Order</label>
            </field>
            <field id="title" translate="label" type="text" sortOrder="2" showInDefault="1" showInWebsite="1" showInStore="1" canRestore="1">
                <label>Title</label>
            </field>
            <field id="sallowspecific" translate="label" type="select" sortOrder="90" showInDefault="1" showInWebsite="1" showInStore="0" canRestore="1">
                <label>Ship to Applicable Countries</label>
                <frontend_class>shipping-applicable-country</frontend_class>
                <source_model>Magento\Shipping\Model\Config\Source\Allspecificcountries</source_model>
            </field>
            <field id="specificcountry" translate="label" type="multiselect" sortOrder="91" showInDefault="1" showInWebsite="1" showInStore="0">
                <label>Ship to Specific Countries</label>
                <source_model>Magento\Directory\Model\Config\Source\Country</source_model>
                <can_be_empty>1</can_be_empty>
            </field>
            <field id="showmethod" translate="label" type="select" sortOrder="92" showInDefault="1" showInWebsite="1" showInStore="0">
                <label>Show Method if Not Applicable</label>
                <source_model>Magento\Config\Model\Config\Source\Yesno</source_model>
                <frontend_class>shipping-skip-hide</frontend_class>
            </field>
            <field id="specificerrmsg" translate="label" type="textarea" sortOrder="80" showInDefault="1" showInWebsite="1" showInStore="1" canRestore="1">
                <label>Displayed Error Message</label>
            </field>
        </group>
    </section> 
```
Para visualizar el método de envío dentro del checkout será necesario realizar el proceso de selección y agregado de productos al checkout y en la pantalla del checkout el método de envío personalizado será mostrado con el titulo y nombre de método ``` Custom Shipping ```, considerar que el precio default del método de envío es de $10, para visualizar la sumatoria con el campo "cobro de envío" se deberá realizar la edición de dicho campo y su respectivo almacenado dentro del panel de administración del proyecto.

## Campos Personalizados en Checkout

- Solicitud: 

  Añade al checkout un campo de texto "comentarios" y un selector obligatorio con al menos dos opciones (ejemplo: "sexo" con opciones "hombre" o “mujer”).

- Solución:
  
  Se crea el ``` custom-checkout-form.js ``` en el directorio ``` \view\frontend\web\js\view ``` con la finalidad de definir el componente del formulario.

  Se genera el template del formulario en el archivo ``` custom-checkout-form.html ``` en el directorio ``` \view\frontend\web\template ``` para agregar knockout.js al componente de formulario.

  Se agrega el archivo ``` checkout_index_index ``` en el directorio ``` \view\frontend\layout ``` con la finalidad de declarar el formulario en el layout del checkout y con esto agregar los campos solicitados.   

## Crea el Observer Post-Compra

- Solicitud:

  Añade al checkout un campo de texto "comentarios" y un selector obligatorio con al menos dos opciones (ejemplo: "sexo" con opciones "hombre" o “mujer”).

- Solución:
  
  
