# Zend Framework 3 / Doctrine 2

**[Proyecto original](https://github.com/zendframework/ZendSkeletonApplication)**

## Introducción

Ejemplo de un modulo REST en **Zend Framework 3** usando **Doctrine**.

## Module Api

Mini-modulo con un controlador REST (user) aplicando los metodos GET, POST, PUT y DELETE.

### config/module.config.php

En este archivo de configuración se da de alta la ruta a al controlador que en este caso es "**/api/products**".
También configura la conexión que tengra doctrine.

## Zend Framework command-line

Para ver los comandos disponibles desde la raíz del proyecto

````
php bin/console list
````

Obtener ayuda de un comando concreto
````
php bin/console orm:schema-tool:create help
````

## Ejemplo de uso



Dentro de este directorio se crean los archivos **PHP** que usara doctrine como entidades.

````php

<?php
// module/Api/src/Models

namespace Api\Models;

/**
 * @Entity @Table(name="Users")
 **/
class User
{

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /**
     * @Column(type="string")
     **/
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName()
        );
    }

}

````

Ahora creamos la base de datos(Este paso varía según el sistema de bbdd elegido).

````
mysql -uroot -p -e "CREATE DATABASE some_db_name;"
````

Creamos creamos el esquema de bbdd

````
php bin/console orm:schema-tool:create
````


## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName zfapp.localhost
    DocumentRoot /path/to/zfapp/public
    <Directory /path/to/zfapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```

### Nginx setup

To setup nginx, open your `/path/to/nginx/nginx.conf` and add an
[include directive](http://nginx.org/en/docs/ngx_core_module.html#include) below
into `http` block if it does not already exist:

```nginx
http {
    # ...
    include sites-enabled/*.conf;
}
```


Create a virtual host configuration file for your project under `/path/to/nginx/sites-enabled/zfapp.localhost.conf`
it should look something like below:

```nginx
server {
    listen       80;
    server_name  zfapp.localhost;
    root         /path/to/zfapp/public;

    location / {
        index index.php;
        try_files $uri $uri/ @php;
    }

    location @php {
        # Pass the PHP requests to FastCGI server (php-fpm) on 127.0.0.1:9000
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_param  SCRIPT_FILENAME /path/to/zfapp/public/index.php;
        include fastcgi_params;
    }
}
```

Restart the nginx, now you should be ready to go!
