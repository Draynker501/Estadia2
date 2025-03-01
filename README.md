# Pasos para dejar funcionando el proyecto

## Requisitos previos

Asegúrate de tener lo siguiente instalado en tu entorno:

- **Laragon** o un entorno de desarrollo similar.
- **PHP 8.3**.
- **Composer** instalado.

## Instrucciones

Sigue estos pasos para dejar funcionando el proyecto:

### 1. Clonar repositorio

Abre la terminal en la ruta `C:\laragon\www` y ejecuta el siguiente comando para clonar el repositorio:

```bash
git clone https://github.com/Draynker501/Estadia2.git
```

### 2. Navegar al directorio del proyecto

Ejecuta el siguiente comando para ubicarte en la ruta del proyecto

```bash
cd Estadia2
```

### 3. Instala dependencias

Utiliza el siguiente comando para instalar las dependencias que el proyecto utiliza actualmente

```bash
composer install
```

### 4. Crear archivo .env

Crea el archivo .env en la raíz del proyecto. Puedes usar el archivo .env.example como base y configura los valores, como el nombre de la base de datos y las configuraciones de MAIL de acuerdo con la herramienta de prueba de correos que estés utilizando.

### 5. Generar clave de aplicación

Ejecuta el siguiente comando para contar con una clave de aplicación única y segura para tu proyecto.

```bash
php artisan key:generate
```

### 6. Ejecutar migraciones 

Ejecuta las migraciones para obtener la base de datos del proyecto

```bash
php artisan migrate
```

### 7. Ejecuta los seeders

Inserta datos en la base de datos ejecutando el siguiente comando

```bash
php artisan db:seed
```

### 8. Probar proyecto

Luego de ejecutar los seeders, se puede probar el proyecto con el navegador o utilizando los test para ver que todo funciona correctamente

```bash
php artisan test
```

Para acceder como Super Admin, las credenciales son las siguientes:

- **Email**: superadmin@gmail.com
- **Password**: superadmin@gmail.com
