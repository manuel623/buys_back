# BuysBack

Este proyecto es el **Backend** de un sistema de órdenes de compra desarrollado como parte de una prueba técnica. Está construido con **Laravel 11.9** y corre sobre **PHP 8.2**.

Repositorio: https://github.com/manuel623/buys_back.git

---

## Stack Utilizado

- **Framework:** Laravel 11.9
- **Lenguaje:** PHP 8.2
- **Base de datos:** MySQL
- **Autenticación:** Laravel Passport
- **Gestión de dependencias:** Composer

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu máquina:

- **PHP 8.2** o superior
- **Composer** (v2 recomendado)
- **MySQL** (o MariaDB)
- **Git**
- **Extensiones PHP necesarias**:
  - `pdo_mysql`
  - `openssl`
  - `mbstring`
  - `tokenizer`
  - `xml`
  - `ctype`
  - `json`

**Recomendación:**  
> Desactivar el antivirus en tiempo real durante la instalación de dependencias
> Algunos antivirus pueden bloquear descargas necesarias de Composer

---

## Instrucciones de Instalación y Ejecución

- **Clonar el repositorio:** `git clone https://github.com/manuel623/buys_back.git`
- **Ingresar al proyecto:** `cd buys_back`
- **Cambiar a la rama correcta** El proyecto tiene dos ramas (main y master); TODO EL CODIGO SE ENCUENTRA EN LA RAMA MASTER `git checkout master`
- **Copiar el archivo de entorno** `cp .env.example .env`
- **Configurar .env** Esta es la configuracion recomendada (utilizada por el creador en su local)
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3307 **Validar este puerto, debe coincidir con el puerto que se este ejecutando en su empaquetador de MySQL, Preferiblemente XAMMP**
    DB_DATABASE=inventory
    DB_USERNAME=root
    DB_PASSWORD=

- **Instalar las dependencias:** `composer install`
- **Generar clave de la aplicacion:** `php artisan key:generate`
- **Ejecutar las migraciones:** `php artisan migrate`
>   Al ejecutar este comando, si la base de datos no existe, Laravel preguntara si desea crearla, Por favor Confirmar este proceso: "yes"

- **Instalar Laravel Passport:** `composer require laravel/passport`
- **Instalar claves primarias de Laravel Passport** `php artisan passport:install`
>   Al ejecutar este comando, Laravel preguntara si desea crear las nuevas tablas y migrarlas, Por favor Confirmar este proceso: "yes"
>   Posteriormente Laravel preguntara si desea crear unas llaves privadas, Por favor Confirmar este proceso: "yes"

- **Ejecutar los Seeders (Datos de Prueba)** `php artisan db:seed`
>   Se creara un data en la tabla user para poder iniciar sesion
    email: admin@admin.com 
    password: 123456
>   Posteriormente se crearan 5 registros en la tabla productos

- **(OPCIONAL)Ejecutar test de listProduct** `php artisan test`

- **Levantar el Proyecto:** `php artisan serve`
>   Validar MUY BIEN si al levantarse el backend muestra la siguiente URL **http://127.0.0.1:8000** en caso de no ser asi, copiar esa url y pegarla en 
    src/environments/environment.ts la variable apiUrl del frontend

## Endpoints de la API Utilizados

Aqui un ejemplo de **ALGUNOS** endpoints utilizados en este proyecto

**Método**	**Endpoint**                                                    **Descripción**
GET	        http://127.0.0.1:8000/api/product/listProduct	                Obtiene todos los productos disponibles
POST	    http://127.0.0.1:8000/api/order/createOrder	                    Crea una nueva orden de compra
GET	        http://127.0.0.1:8000/api/orderDetail/getOrderDetails/{id}	    Obtiene detalles de una orden específica
GET	        http://127.0.0.1:8000/api/product/topPurchasedProducts	        Devuelve los productos más vendidos

## Pruebas en Postman

**1**
- Método: POST

- URL: http://127.0.0.1:8000/api/login

- Body (JSON): 
    {
        "email": "admin@admin.com",
        "password": "123456"
    }

> Este endpoint devolvera un access_token en la respuesta, con este token se pondran consumir otros endpoint protedigos con middleware

**2**

- Método: GET

- URL: http://127.0.0.1:8000/api/buyer/listBuyer

- Authorization:

- Tipo: Bearer Token
- Token: valor de access_token

> Este endpoint respondera todos los compradores que han sido registrados

**NOTA:** Los endpoints protegidos requieren autenticación Bearer Token usando Passport

## Anotaciones Técnicas Relevantes

- Se utiliza Laravel Passport para gestionar la autenticación OAuth2

- Las migraciones crean las tablas necesarias automáticamente (buyers, products, orders, etc.)

- Los Seeders cargan datos iniciales de prueba

- Proyecto preparado para escalar nuevas funcionalidades de forma sencilla

- Código limpio y siguiendo las mejores prácticas de Laravel 11

- Uso de políticas y requests para validaciones de acceso y datos

## Autor

- Desarrollado por Manuel Cardona Martinez como parte de una prueba técnica para: S.G.I S.A.S