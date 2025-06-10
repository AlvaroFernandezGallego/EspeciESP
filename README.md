# EspeciESP

## Índice

- [Introducción](#introducción)
- [Requisitos Previos](#requisitos-previos)
- [Guía de Instalación y Despliegue](#guía-de-instalación-y-despliegue)
  - [1. Instalación de PHP y XAMPP](#1-instalación-de-php-y-xampp)
  - [2. Instalación de Scoop (Windows)](#2-instalación-de-scoop-windows)
  - [3. Instalación de Symfony CLI](#3-instalación-de-symfony-cli)
  - [4. Clonación y Acceso al Proyecto](#4-clonación-y-acceso-al-proyecto)
  - [5. Configuración de la Base de Datos](#5-configuración-de-la-base-de-datos)
  - [6. Importación de Datos de Prueba](#6-importación-de-datos-de-prueba)
  - [7. Ejecución del Servidor Symfony](#7-ejecución-del-servidor-symfony)
  - [8. Compilación de Recursos Frontend](#8-compilación-de-recursos-frontend)
  - [9. Gestión de Migraciones](#9-gestión-de-migraciones)
  - [10. Instalación de Tailwind CSS](#10-instalación-de-tailwind-css-en-symfony)
- [Resumen de Comandos](#resumen-de-comandos)
- [Credenciales por Defecto](#credenciales-por-defecto)
- [Repositorio](#repositorio)
- [Contacto](#contacto)

---

## Introducción

Este documento detalla el procedimiento para desplegar localmente el proyecto **EspeciESP**, una aplicación desarrollada con Symfony. Aquí se incluyen las instrucciones para la instalación de dependencias, configuración de base de datos, ejecución del entorno de desarrollo y la integración de **Tailwind CSS** para el frontend.

---

## Requisitos Previos

- PHP 8.1 o superior  
- XAMPP (Apache, MySQL)  
- Scoop (gestor de paquetes para Windows)  
- Symfony CLI  
- Node.js y NPM  

---

## Guía de Instalación y Despliegue

### 1. Instalación de PHP y XAMPP

- Descargue PHP.
- Instale XAMPP.
- Inicie Apache y MySQL desde el panel de control XAMPP.

---

### 2. Instalación de Scoop (Windows)

Abra PowerShell como administrador y ejecute:

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
iex "& {$(irm get.scoop.sh)} -RunAsAdmin"
````

---

### 3. Instalación de Symfony CLI

Con Scoop instalado, ejecute:

```powershell
scoop install symfony-cli
```

Valide la instalación:

```bash
symfony check:requirements
```

---

### 4. Clonación y Acceso al Proyecto

Clonar el repositorio y acceder a la carpeta raíz en `C:\xampp\htdocs`:

```bash
cd C:\xampp\htdocs\EspeciESP\project
```

---

### 5. Configuración de la Base de Datos

* Crear base de datos:

```bash
symfony console doctrine:database:create
```

* Generar migraciones:

```bash
symfony console make:migration
```

* Ejecutar migraciones:

```bash
symfony console doctrine:migrations:migrate
```

---

### 6. Importación de Datos de Prueba

* Acceda a phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
* Seleccione la base de datos `especiesp`
* Importe el archivo `speciesp.sql` desde el directorio del proyecto.

---

### 7. Ejecución del Servidor Symfony

Inicie el servidor en modo demonio:

```bash
symfony serve -d
```

Acceda a la aplicación en:

```
http://127.0.0.1:8000
```

Para detener el servidor:

```bash
symfony server:stop
```

---

### 8. Compilación de Recursos Frontend

Si modifica CSS o JavaScript, compile assets con:

```bash
npm run dev
```

---

### 9. Gestión de Migraciones

Cada vez que realice cambios en entidades:

```bash
symfony console make:migration
symfony console doctrine:migrations:migrate
```

---

### 10. Instalación de Tailwind CSS en Symfony

#### 1. Situarte correctamente en el proyecto

Sitúate dentro del directorio 'project'

```bash
cd project
```

#### 2. Instalar Webpack Encore

Instala **Webpack Encore**, que se encargará de la compilación de tus recursos:

```bash
composer remove symfony/ux-turbo symfony/asset-mapper symfony/stimulus-bundle
composer require symfony/webpack-encore-bundle symfony/ux-turbo symfony/stimulus-bundle
```

#### 3. Instalar Tailwind CSS

Usa **npm** para instalar **Tailwind CSS** y sus dependencias necesarias:

```bash
npm install tailwindcss @tailwindcss/postcss postcss postcss-loader
```

#### 4. Habilitar el soporte de PostCSS

En tu archivo `webpack.config.js`, habilita el **PostCSS Loader**:

```javascript
Encore.enablePostCssLoader();
```

#### 5. Configurar los plugins de PostCSS

Crea el archivo `postcss.config.mjs` dentro del directorio 'project' y agrega el plugin de Tailwind CSS:

```javascript
export default {
  plugins: {
    '@tailwindcss/postcss': {},
  },
};
```

#### 6. Importar Tailwind CSS

Agrega la importación de Tailwind CSS en tu archivo `./assets/styles/app.css`:

```css
@import "tailwindcss";
```

#### 7. Iniciar el proceso de compilación

Corre el proceso de compilación con:

```bash
npm run watch
```

#### 8. Empezar a usar Tailwind en tu Proyecto

Asegúrate de que tu archivo CSS compilado se incluya en el `<head>` de tus plantillas y empieza a usar las clases de utilidad de Tailwind en tu HTML:

```html
<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {% block stylesheets %}
      {{ encore_entry_link_tags('app') }}
    {% endblock %}
  </head>
  <body>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
  </body>
</html>
```

---

## Resumen de Comandos

| Acción                         | Comando                                       |
| ------------------------------ | --------------------------------------------- |
| Acceso al proyecto             | `cd C:\ruta\del\proyecto\EspeciESP\project`   |
| Crear base de datos            | `symfony console doctrine:database:create`    |
| Generar migración              | `symfony console make:migration`              |
| Aplicar migraciones            | `symfony console doctrine:migrations:migrate` |
| Iniciar servidor               | `symfony serve -d`                            |
| Detener servidor               | `symfony server:stop`                         |
| Compilar recursos frontend     | `npm run dev`                                 |
| Verificar requisitos Symfony   | `symfony check:requirements`                  |
| Instalar Symfony CLI con Scoop | `scoop install symfony-cli`                   |

---

## Credenciales por Defecto

* Usuario administrador: `admin@especiesp.com`
* Contraseña: `Administrador123!`

> **Nota:** Se recomienda modificar estas credenciales en ambientes de producción.

---

## Repositorio

[https://github.com/AlvaroFernandezGallego/EspeciESP](https://github.com/AlvaroFernandezGallego/EspeciESP)

---

## Contacto

Para consultas o reportes, abra un *issue* en el repositorio o contacte con el equipo de desarrollo.
