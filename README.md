# Despliegue del Proyecto EspeciESP en Entorno Local

Este documento describe el proceso necesario para desplegar y ejecutar el proyecto **EspeciESP** en un entorno local. El despliegue está basado en herramientas ampliamente utilizadas como **Symfony**, **PHP**, **XAMPP**, y **Scoop**, entre otras.

## Requisitos Previos

Antes de comenzar, asegúrese de tener instaladas las siguientes herramientas en su máquina local:

- **PHP** (preferentemente versión 8.1 o superior)
- **XAMPP** (que incluye Apache, MySQL y PHP)
- **Scoop** (gestor de paquetes para Windows)
- **Symfony CLI** (herramienta de línea de comandos para Symfony)

## Pasos para el Despliegue

### 1. Instalación de PHP y XAMPP

Para comenzar, debe instalar **PHP** y **XAMPP**:

1. **PHP**: Descargue e instale PHP desde su [página oficial](https://www.php.net/downloads.php). Asegúrese de tener una versión compatible con Symfony (preferentemente PHP 8.1 o superior).

2. **XAMPP**: Descargue e instale XAMPP desde [este enlace](https://www.apachefriends.org/index.html). XAMPP incluye Apache y MySQL, que son necesarios para ejecutar el servidor y la base de datos de la aplicación.

Una vez instalado **XAMPP**, asegúrese de iniciar el **servidor Apache** y **MySQL** desde el panel de control de XAMPP.

### 2. Instalación de Scoop (Gestor de Paquetes para Windows)

A continuación, instalaremos **Scoop**, un gestor de paquetes para Windows que facilitará la instalación de herramientas de desarrollo como Symfony.

1. Abra **PowerShell** en **modo Administrador** y ejecute los siguientes comandos:

    ```powershell
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
    Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
    iex "& {$(irm get.scoop.sh)} -RunAsAdmin"
    ```

2. Esto instalará **Scoop** en su sistema. Scoop simplificará la instalación de herramientas como **Symfony**.

### 3. Instalación de Symfony CLI a Través de Scoop

Una vez que **Scoop** esté instalado, puede instalar **Symfony CLI** ejecutando el siguiente comando en PowerShell:

```powershell
scoop install symfony-cli
````

Verifique que la instalación fue exitosa ejecutando el siguiente comando:

```bash
symfony check:requirements
```

Este comando comprobará que todos los requisitos del sistema necesarios para ejecutar Symfony estén correctamente configurados.

### 4. Acceso al Directorio del Proyecto

Acceda al directorio del proyecto **EspeciESP** utilizando la terminal. Ejecute el siguiente comando:

```bash
cd C:\ruta\del\proyecto\EspeciESP\project
```

Asegúrese de estar en el directorio adecuado (`project`), ya que los siguientes comandos deben ejecutarse en esta carpeta.

### 5. Creación de la Base de Datos

Una vez que se haya accedido al directorio del proyecto, debe crear la base de datos. Para ello, ejecute el siguiente comando en la terminal:

```bash
symfony console doctrine:database:create
```

Este comando utiliza **Doctrine ORM** para crear la base de datos, basada en la configuración de la base de datos definida en el archivo `.env`.

### 6. Generación y Ejecución de Migraciones

Después de crear la base de datos, es necesario generar las migraciones para crear las tablas en la base de datos. Ejecute el siguiente comando para generar las migraciones:

```bash
symfony console make:migration
```

Una vez generada la migración, ejecute el siguiente comando para aplicar las migraciones y crear las tablas en la base de datos:

```bash
symfony console doctrine:migrations:migrate
```

Este comando aplicará las migraciones generadas y creará las tablas y relaciones en la base de datos.

### 7. Importación de Datos de Prueba

Para poblar las tablas con datos de prueba, acceda a **phpMyAdmin**, seleccione la base de datos `especiesp` y ejecute las sentencias SQL contenidas en el archivo `speciesp.sql`. Este archivo se encuentra en el directorio del proyecto y contiene los datos necesarios para realizar pruebas en la aplicación.

### 8. Iniciar el Servidor de Desarrollo

Una vez que la base de datos esté configurada y poblada con los datos de prueba, puede iniciar el servidor de desarrollo de Symfony. Ejecute el siguiente comando en la terminal:

```bash
symfony serve -d
```

Este comando iniciará el servidor en segundo plano. Podrá acceder a la aplicación a través de su navegador en la dirección:

```
http://127.0.0.1:8000
```

Si desea detener el servidor en cualquier momento, ejecute:

```bash
symfony server:stop
```

### 9. Edición de Estilos y Aplicación de Cambios en el Frontend

Si desea realizar cambios en los archivos de estilo o en los scripts del frontend (como archivos CSS o JavaScript), ejecute el siguiente comando para compilar los **assets**:

```bash
npm run dev
```

Esto procesará los archivos **CSS**, **JavaScript** e imágenes del proyecto. Para ver los cambios reflejados en el navegador, asegúrese de **borrar la caché** o el **historial de navegación**.

### 10. Gestión de Migraciones para Nuevos Cambios en las Entidades

Si realiza cambios en las entidades del proyecto (por ejemplo, agregando nuevas columnas o modificando relaciones), será necesario generar nuevas migraciones. Para ello, ejecute los siguientes comandos:

1. Generar una nueva migración:

   ```bash
   symfony console make:migration
   ```

2. Aplicar la migración:

   ```bash
   symfony console doctrine:migrations:migrate
   ```

Este proceso asegurará que la base de datos esté siempre sincronizada con las entidades del proyecto.

---

## Resumen de Comandos

A continuación, se muestra un resumen de los comandos utilizados para desplegar el proyecto:

1. **Instalar PHP y XAMPP**:

   * Instalar PHP y XAMPP siguiendo las instrucciones mencionadas previamente.

2. **Instalar Scoop y Symfony**:

   * `scoop install symfony-cli`

3. **Acceder al directorio del proyecto**:

   * `cd C:\ruta\del\proyecto\EspeciESP\project`

4. **Crear la base de datos**:

   * `symfony console doctrine:database:create`

5. **Generar y ejecutar migraciones**:

   * `symfony console make:migration`
   * `symfony console doctrine:migrations:migrate`

6. **Importar datos de prueba**:

   * Ejecutar las sentencias SQL desde `speciesp.sql` en phpMyAdmin.

7. **Iniciar el servidor**:

   * `symfony serve -d`
   * `symfony server:stop` (para detener el servidor)

8. **Editar y compilar assets**:

   * `npm run dev` (para compilar los cambios de frontend)

9. **Gestionar nuevas migraciones**:

   * `symfony console make:migration`
   * `symfony console doctrine:migrations:migrate`

# Administrador

admin@especiesp.com 

# Contraseña

admin123

# Enlace al repositorio público en GitHub

https://github.com/AlvaroFernandezGallego/EspeciESP