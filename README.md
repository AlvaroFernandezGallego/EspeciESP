# EspeciESP

# 📦 Guía Completa para el Despliegue Local del Proyecto **EspeciESP**

Este documento proporciona una guía técnica detallada para la instalación, configuración y despliegue local del sistema **EspeciESP**, una aplicación desarrollada con el framework **Symfony**. Se abordarán los pasos necesarios para establecer un entorno de desarrollo funcional en una máquina local, incluyendo la configuración de servicios, base de datos, dependencias y herramientas asociadas.

---

## ✅ Requisitos Previos

Antes de proceder con la instalación del proyecto, asegúrese de contar con los siguientes componentes y herramientas:

* **PHP** (versión 8.1 o superior recomendada)
* **XAMPP** (incluye Apache, MySQL y PHP)
* **Scoop** (gestor de paquetes para entornos Windows)
* **Symfony CLI** (utilidad de línea de comandos para proyectos Symfony)
* **Node.js y NPM** (para la gestión y compilación de assets)

---

## 🛠️ Guía Paso a Paso para el Despliegue

### 1. Instalación de PHP y XAMPP

#### PHP

Descargue e instale PHP.

Verifique que la versión instalada sea compatible con Symfony (mínimo PHP 8.1).

#### XAMPP

Instale XAMPP.

Después de la instalación:

* Inicie los servicios de **Apache** y **MySQL** desde el panel de control de XAMPP.
* Verifique que ambos servicios estén ejecutándose correctamente.

---

### 2. Instalación de Scoop (Solo para Windows)

Scoop facilita la instalación de herramientas de desarrollo desde la terminal de PowerShell.

#### Pasos:

1. Abra **PowerShell como Administrador**.
2. Ejecute los siguientes comandos:

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
iex "& {$(irm get.scoop.sh)} -RunAsAdmin"
```

Esto instalará Scoop y habilitará el entorno para instalar Symfony CLI de forma sencilla.

---

### 3. Instalación de Symfony CLI

Una vez Scoop esté operativo, ejecute el siguiente comando en PowerShell para instalar Symfony CLI:

```powershell
scoop install symfony-cli
```

Verifique que la instalación haya sido exitosa ejecutando:

```bash
symfony check:requirements
```

Este comando analizará su entorno local para asegurar que cumple con los requisitos mínimos de Symfony.

---

### 4. Clonar y Acceder al Proyecto

Clonar el repositorio desde GitHub o ubique la carpeta del proyecto en su sistema. Luego acceda a la carpeta raíz del proyecto Symfony:

```bash
cd C:\ruta\del\proyecto\EspeciESP\project
```

⚠️ **Importante**: Asegúrese de encontrarse en el directorio `project` del repositorio, ya que todos los comandos deben ejecutarse desde allí.

---

### 5. Configuración de la Base de Datos

#### Creación de la Base de Datos

Ejecute el siguiente comando:

```bash
symfony console doctrine:database:create
```

Este comando creará la base de datos definida en el archivo `.env` del proyecto.

#### Configuración de las Entidades y Tablas

1. Genere las migraciones:

```bash
symfony console make:migration
```

2. Aplique las migraciones para construir la estructura de la base de datos:

```bash
symfony console doctrine:migrations:migrate
```

---

### 6. Importación de Datos de Prueba

1. Acceda a **phpMyAdmin** desde el panel de XAMPP: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Seleccione la base de datos `especiesp`.
3. Importe el archivo `speciesp.sql` ubicado en el directorio del proyecto, el cual contiene datos de prueba para la aplicación.

---

### 7. Iniciar el Servidor Symfony

Una vez configurada la base de datos, inicie el servidor de desarrollo:

```bash
symfony serve -d
```

Esto ejecutará la aplicación en segundo plano. Acceda desde su navegador a:

```
http://127.0.0.1:8000
```

Para detener el servidor:

```bash
symfony server:stop
```

---

### 8. Gestión de Nuevas Migraciones

Cuando se realicen cambios en las entidades (por ejemplo, campos nuevos o relaciones), siga este procedimiento:

1. Generar nuevas migraciones:

```bash
symfony console make:migration
```

2. Aplicar las migraciones:

```bash
symfony console doctrine:migrations:migrate
```

Esto garantizará que la base de datos se mantenga sincronizada con el modelo de datos del proyecto.

---

## 📄 Resumen de Comandos Utilizados

| Propósito                        | Comando                                       |
| -------------------------------- | --------------------------------------------- |
| Acceder al proyecto              | `cd C:\ruta\del\proyecto\EspeciESP\project`   |
| Crear la base de datos           | `symfony console doctrine:database:create`    |
| Generar migraciones              | `symfony console make:migration`              |
| Ejecutar migraciones             | `symfony console doctrine:migrations:migrate` |
| Iniciar servidor de desarrollo   | `symfony serve -d`                            |
| Detener servidor de desarrollo   | `symfony server:stop`                         |
| Verificar requisitos Symfony     | `symfony check:requirements`                  |
| Instalar Symfony CLI (con Scoop) | `scoop install symfony-cli`                   |

---

## 🔐 Credenciales por Defecto

* **Usuario administrador**: `admin@especiesp.com`
* **Contraseña**: `admin123`

⚠️ *Por motivos de seguridad, se recomienda modificar estas credenciales en entornos de producción.*

---

## 🌐 Enlace al Repositorio

Puede acceder al repositorio del proyecto EspeciESP en GitHub a través del siguiente enlace:

🔗 [https://github.com/AlvaroFernandezGallego/EspeciESP](https://github.com/AlvaroFernandezGallego/EspeciESP)

---

## 📬 Contacto

Para cualquier duda o sugerencia relacionada con el despliegue del proyecto, no dude en abrir un *issue* en el repositorio o contactar directamente con los responsables del desarrollo.