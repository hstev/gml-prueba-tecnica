# GML Prueba técnica: Laravel
# Caracteristicas
- PHP 7.4+
- NPM 8.19.3
- Composer 2.5.1
- Laravel 10.x
- Vue 3 con Vuetify 3
- SMTP mailtrap
- Mysql

# Utilizado en la prueba
- Events
- Listeners
- Commands
- Schedulers
- Mailing
- Migrations
- Factories
- Seeders
- API REST

# Guia 

## Clonar el proyecto
```sh
 git clone https://github.com/hstev/gml-prueba-tecnica.git
```

## Ingresar a la carpeta
```sh
 cd gml-prueba-tecnica
```

## Crear .env desde .env.example
```sh
 cp .env.example .env
```
## Configurar el correo del admin en .env
```sh
MAIL_ADMIN=admin@example.com
```

## Configurar el proveedor de MAIL
```sh
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```
En mi caso utilizé [Mailtrap][mailtrap] (Solo es necesario registrarse y copiar los datos para Laravel 7+)
## Configurar APP_URL de laravel (si es necesario)
```sh
APP_URL=http://127.0.0.1:8000
```
## Ejecutar las migraciones
```sh
php artisan migrate
```
NOTA: Es necesario tener mysql corriendo, ya sea como servicio en linux o a traves de programas como XAMP o Laragon (Windows).
## Ejecutar el seed (crear las categorías y algunos usuarios random)
```sh
php artisan db:seed
```
## Instalar dependencias con Composer y NPM
```sh
composer install
```
```sh
npm install 
```
## Compilar dev o prod
```sh
npm run build
```
## Servir aplicación
```sh
php artisan serve
```
## Abrir en el navegador
[http://127.0.0.1:8000][localhost]

[mailtrap]: <https://mailtrap.io/>
[localhost]: <http://127.0.0.1:8000>