# administracion_inventario
 Administración de artículos de inventario con Laravel
# Tutorial

# Instalación
* Clonar repositorio
* Instalar composer
* Instalar dependencias con `composer install`
* Configurar env; es decir, crear un archivo llamado **.env** tomando como ejemplo **.env.example** y configurar las credenciales
* Crear la base de datos que se indicó en **.env**
* Realiza la migración con `php artisan migrate`
* Ahora en MySQL crea un usuario dentro de la tabla; que puede ser con:
```sql
insert into usuarios (nombre, password) values ('parzibyte', '$2y$10$vtiiIwVGb3kIg2wRBsPz/exsAEWeKKc92Ic397p7TeUtx8baswnp2');
```
Eso hará que exista un usuario llamado **parzibyte** con la contraseña **hunter2**. Por el momento Laravel usa bcrypt así que si quieres generar tu propia contraseña puedes obtenerla con php:
```php
<?php
$hasheada = password_hash('123', PASSWORD_BCRYPT);
echo $hasheada;
```

* Visita https://parzibyte.me/blog para más software open source
